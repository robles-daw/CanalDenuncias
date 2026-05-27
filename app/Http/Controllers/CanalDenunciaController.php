<?php

namespace App\Http\Controllers;

use App\Mail\CodigoSeguimientoMail;
use App\Mail\DenunciaRegistradaMail;
use App\Models\Denuncia;
use App\Models\DenunciaAdjunto;
use App\Models\DenunciaImplicado;
use App\Models\CausaDenuncia;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CanalDenunciaController extends Controller
{
    public function landing(): View
    {
        return view('canal-denuncias.landing', [
            'empresas' => Empresa::query()
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function show(Empresa $empresa): View
    {
        return view('canal-denuncias.show', [
            'empresa' => $empresa,
            'causas' => $this->causasActivas(),
        ]);
    }

    public function store(Request $request, Empresa $empresa): RedirectResponse
    {
        $anonima = $request->boolean('anonima');

        $validated = $request->validate([
            'causa_denuncia_id' => ['required', 'integer', 'exists:causa_denuncias,id'],
            'descripcion_hechos' => ['required', 'string', 'max:10000'],
            'fecha_hechos' => ['nullable', 'date'],
            'sigue_ocurriendo' => ['nullable', 'boolean'],
            'riesgo_inmediato' => ['nullable', 'boolean'],
            'anonima' => ['nullable', 'boolean'],
            'nombre_denunciante' => [$anonima ? 'nullable' : 'required_without:email_denunciante', 'string', 'max:255'],
            'email_denunciante' => [$anonima ? 'nullable' : 'required_without:nombre_denunciante', 'nullable', 'email', 'max:255'],
            'telefono_denunciante' => ['nullable', 'string', 'max:30'],
            'personas_implicadas' => ['nullable', 'string', 'max:4000'],
            'acepta_politica_privacidad' => ['accepted'],
            'declara_veracidad' => ['accepted'],
            'adjuntos.*' => ['nullable', 'file', 'max:10240'],
        ], [
            'causa_denuncia_id.required' => 'Selecciona un motivo de denuncia de la lista sugerida.',
            'causa_denuncia_id.exists' => 'Selecciona un motivo de denuncia válido de la lista sugerida.',
            'acepta_politica_privacidad.accepted' => 'Debes aceptar la politica de privacidad.',
            'declara_veracidad.accepted' => 'Debes confirmar la declaracion de veracidad.',
        ]);

        $denuncia = DB::transaction(function () use ($request, $empresa, $validated, $anonima) {
            $denuncia = Denuncia::query()->create([
                'empresa_id' => $empresa->id,
                'causa_denuncia_id' => $validated['causa_denuncia_id'],
                'codigo_seguimiento' => $this->generarCodigoSeguimiento($empresa),
                'estado' => 'pendiente',
                'descripcion_hechos' => $validated['descripcion_hechos'],
                'fecha_hechos' => $validated['fecha_hechos'] ?? null,
                'sigue_ocurriendo' => $request->has('sigue_ocurriendo') ? $request->boolean('sigue_ocurriendo') : null,
                'riesgo_inmediato' => $request->boolean('riesgo_inmediato'),
                'anonima' => $anonima,
                'nombre_denunciante' => $anonima ? null : ($validated['nombre_denunciante'] ?? null),
                'email_denunciante' => $anonima ? null : ($validated['email_denunciante'] ?? null),
                'telefono_denunciante' => $anonima ? null : ($validated['telefono_denunciante'] ?? null),
                'acepta_politica_privacidad' => true,
                'declara_veracidad' => true,
                'ip_origen' => $request->ip(),
                'user_agent' => Str::limit((string) $request->userAgent(), 65535, ''),
                'metadatos' => [
                    'origen' => 'web',
                    'dominio_empresa' => $empresa->dominio,
                ],
                'fecha_recepcion' => now(),
            ]);

            $this->guardarImplicados($denuncia, (string) ($validated['personas_implicadas'] ?? ''));
            $this->guardarAdjuntos($request, $denuncia);

            return $denuncia;
        });

        $destinatario = $empresa->email_canal_denuncias ?: $empresa->email;

        if ($destinatario) {
            Mail::to($destinatario)->send(new DenunciaRegistradaMail(
                $denuncia->loadMissing(['empresa', 'causa']),
            ));
        }

        return redirect()->route('canal-denuncias.confirmacion', [
            'empresa' => $empresa->dominio,
            'codigo' => $denuncia->codigo_seguimiento,
        ]);
    }

    public function confirmation(Empresa $empresa, string $codigo): View
    {
        $denuncia = Denuncia::query()
            ->where('empresa_id', $empresa->id)
            ->where('codigo_seguimiento', $codigo)
            ->with('causa')
            ->firstOrFail();

        return view('canal-denuncias.confirmation', [
            'empresa' => $empresa,
            'denuncia' => $denuncia,
        ]);
    }

    public function sendTrackingCode(Request $request, Empresa $empresa, string $codigo): RedirectResponse
    {
        $validated = $request->validate([
            'email_destino' => ['required', 'email', 'max:255'],
        ]);

        $denuncia = Denuncia::query()
            ->where('empresa_id', $empresa->id)
            ->where('codigo_seguimiento', $codigo)
            ->with(['empresa', 'causa'])
            ->firstOrFail();

        Mail::to($validated['email_destino'])->send(new CodigoSeguimientoMail($denuncia));

        return redirect()
            ->route('canal-denuncias.confirmacion', [
                'empresa' => $empresa->dominio,
                'codigo' => $codigo,
            ])
            ->with('tracking_code_sent', 'El código de seguimiento se ha enviado al correo indicado.');
    }

    public function tracking(Empresa $empresa, Request $request): View
    {
        $denuncia = null;
        $codigo = trim((string) $request->query('codigo', ''));

        if ($codigo !== '') {
            $denuncia = Denuncia::query()
                ->where('empresa_id', $empresa->id)
                ->where('codigo_seguimiento', $codigo)
                ->with('causa')
                ->first();
        }

        return view('canal-denuncias.tracking', [
            'empresa' => $empresa,
            'denuncia' => $denuncia,
            'codigo' => $codigo,
            'busquedaRealizada' => $codigo !== '',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, CausaDenuncia>
     */
    protected function causasActivas()
    {
        return CausaDenuncia::query()
            ->where('activa', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();
    }

    protected function generarCodigoSeguimiento(Empresa $empresa): string
    {
        do {
            $codigo = Str::upper(Str::slug($empresa->dominio)).'-'.Str::upper(Str::random(10));
        } while (
            Denuncia::query()->where('codigo_seguimiento', $codigo)->exists()
        );

        return $codigo;
    }

    protected function guardarImplicados(Denuncia $denuncia, string $personasImplicadas): void
    {
        $lineas = preg_split('/\r\n|\r|\n/', $personasImplicadas) ?: [];

        foreach ($lineas as $indice => $linea) {
            $nombre = trim($linea);

            if ($nombre === '') {
                continue;
            }

            DenunciaImplicado::query()->create([
                'denuncia_id' => $denuncia->id,
                'nombre' => $nombre,
                'orden' => $indice + 1,
            ]);
        }
    }

    protected function guardarAdjuntos(Request $request, Denuncia $denuncia): void
    {
        foreach ($request->file('adjuntos', []) as $archivo) {
            $ruta = $archivo->store('denuncias/'.$denuncia->id, 'local');

            DenunciaAdjunto::query()->create([
                'denuncia_id' => $denuncia->id,
                'nombre_original' => $archivo->getClientOriginalName(),
                'ruta_archivo' => $ruta,
                'mime_type' => $archivo->getClientMimeType(),
                'tamano_bytes' => $archivo->getSize(),
            ]);
        }
    }
}
