<?php

namespace App\Http\Controllers;

use App\Models\CausaDenuncia;
use App\Models\Denuncia;
use App\Models\Empresa;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminEmpresaController extends Controller
{
    public function index(): View
    {
        return view('admin.empresas.index', [
            'empresas' => Empresa::query()
                ->orderByDesc('id')
                ->get(),
        ]);
    }

    public function stats(Empresa $empresa): View
    {
        $baseQuery = Denuncia::query()->where('empresa_id', $empresa->id);
        $totalDenuncias = (clone $baseQuery)->count();
        $denunciasConTelefono = (clone $baseQuery)
            ->whereNotNull('telefono_denunciante')
            ->where('telefono_denunciante', '!=', '')
            ->count();
        $denunciasAnonimas = (clone $baseQuery)
            ->where('anonima', true)
            ->count();
        $denunciasConEmail = (clone $baseQuery)
            ->whereNotNull('email_denunciante')
            ->where('email_denunciante', '!=', '')
            ->count();

        $denunciasPorTipo = CausaDenuncia::query()
            ->orderBy('nombre')
            ->get()
            ->map(function (CausaDenuncia $causa) use ($empresa, $totalDenuncias): array {
                $total = Denuncia::query()
                    ->where('empresa_id', $empresa->id)
                    ->where('causa_denuncia_id', $causa->id)
                    ->count();

                return [
                    'nombre' => $causa->nombre,
                    'total' => $total,
                    'porcentaje' => $totalDenuncias > 0 ? round(($total / $totalDenuncias) * 100, 1) : 0,
                ];
            })
            ->filter(fn (array $tipo): bool => $tipo['total'] > 0)
            ->values();

        $estadoLabels = [
            'pendiente' => 'Pendiente',
            'en_revision' => 'En revisión',
            'resuelta' => 'Resuelta',
            'archivada' => 'Archivada',
        ];

        $denunciasPorEstado = collect($estadoLabels)->map(function (string $label, string $estado) {
            return [
                'estado' => $estado,
                'label' => $label,
                'total' => 0,
            ];
        });

        (clone $baseQuery)
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get()
            ->each(function (Denuncia $denuncia) use ($denunciasPorEstado): void {
                if (! $denunciasPorEstado->has($denuncia->estado)) {
                    $denunciasPorEstado->put($denuncia->estado, [
                        'estado' => $denuncia->estado,
                        'label' => $denuncia->estado_label,
                        'total' => 0,
                    ]);
                }

                $current = $denunciasPorEstado->get($denuncia->estado);
                $current['total'] = (int) $denuncia->total;
                $denunciasPorEstado->put($denuncia->estado, $current);
            });

        $denunciasPorEstado = $denunciasPorEstado->values();
        $maxDenunciasEstado = max(1, (int) $denunciasPorEstado->max('total'));

        $stats = [
            'total_denuncias' => $totalDenuncias,
            'con_telefono' => $denunciasConTelefono,
            'sin_telefono' => max($totalDenuncias - $denunciasConTelefono, 0),
            'anonimas' => $denunciasAnonimas,
            'con_email' => $denunciasConEmail,
        ];

        return view('admin.empresas.stats', [
            'empresa' => $empresa,
            'stats' => $stats,
            'denunciasPorTipo' => $denunciasPorTipo,
            'denunciasPorEstado' => $denunciasPorEstado,
            'maxDenunciasEstado' => $maxDenunciasEstado,
        ]);
    }

    public function create(): View
    {
        return view('admin.empresas.create', [
            'empresa' => new Empresa(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateEmpresa($request);
        $empresa = new Empresa();

        $this->fillEmpresa($empresa, $data, $request);
        $empresa->save();

        return redirect()
            ->route('admin.empresas.index')
            ->with('status', 'Empresa creada correctamente.');
    }

    public function edit(Empresa $empresa): View
    {
        return view('admin.empresas.edit', [
            'empresa' => $empresa,
        ]);
    }

    public function update(Request $request, Empresa $empresa): RedirectResponse
    {
        $data = $this->validateEmpresa($request, $empresa);

        $this->fillEmpresa($empresa, $data, $request);
        $empresa->save();

        return redirect()
            ->route('admin.empresas.index')
            ->with('status', 'Empresa actualizada correctamente.');
    }

    public function destroy(Request $request, Empresa $empresa): RedirectResponse
    {
        $request->validate([
            'confirmacion_eliminacion' => ['required', 'in:'.$empresa->nombre],
        ], [
            'confirmacion_eliminacion.in' => 'Debes escribir el nombre exacto de la empresa para eliminarla.',
        ]);

        try {
            $empresa->delete();
        } catch (QueryException) {
            return back()->withErrors([
                'confirmacion_eliminacion' => 'No se puede eliminar la empresa porque tiene información relacionada.',
            ]);
        }

        return redirect()
            ->route('admin.empresas.index')
            ->with('status', 'Empresa eliminada correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validateEmpresa(Request $request, ?Empresa $empresa = null): array
    {
        $empresaId = $empresa?->id;

        if ($request->input('color_secundario') === '') {
            $request->merge([
                'color_secundario' => null,
            ]);
        }

        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'dominio' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:empresas,dominio,'.($empresaId ?? 'NULL').',id'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [$empresa ? 'nullable' : 'required', 'string', 'min:8', 'max:255'],
            'logo' => [$empresa ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'pdf_normativa' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'color_principal' => ['required', 'string', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
            'color_secundario' => ['nullable', 'string', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
        ], [
            'color_principal.regex' => 'Introduce un color principal válido en formato hexadecimal.',
            'color_secundario.regex' => 'Introduce un color secundario válido en formato hexadecimal o déjalo vacío.',
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function fillEmpresa(Empresa $empresa, array $data, Request $request): void
    {
        $empresa->nombre = $data['nombre'];
        $empresa->slug = Str::slug($data['nombre']);
        $empresa->dominio = $data['dominio'];
        $empresa->email = $data['email'];
        $empresa->email_canal_denuncias = $data['email'];
        $empresa->activa = true;
        $empresa->color_principal = $data['color_principal'];
        $empresa->color_secundario = $data['color_secundario'] ?: null;

        if (! empty($data['password'])) {
            $empresa->password = $data['password'];
        }

        if ($request->hasFile('logo')) {
            $empresa->logo = $this->storeUploadedFile($request->file('logo'), 'uploads/logos');
        }

        if ($request->hasFile('pdf_normativa')) {
            $pdfPath = $this->storeUploadedFile($request->file('pdf_normativa'), 'uploads/normativas');
            $empresa->pdf_normativa = $pdfPath;
            $empresa->pdf = $pdfPath;
        }
    }

    protected function storeUploadedFile(\Illuminate\Http\UploadedFile $file, string $directory): string
    {
        $targetDirectory = public_path($directory);
        File::ensureDirectoryExists($targetDirectory);

        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $file->move($targetDirectory, $filename);

        return $directory.'/'.$filename;
    }
}
