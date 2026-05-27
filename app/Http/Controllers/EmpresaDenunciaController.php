<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\DenunciaAdjunto;
use App\Models\Empresa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmpresaDenunciaController extends Controller
{
    public function index(Empresa $empresa, Request $request): View
    {
        $estado = $request->query('estado');

        $denuncias = Denuncia::query()
            ->where('empresa_id', $empresa->id)
            ->when($estado, fn ($query) => $query->where('estado', $estado))
            ->with('causa')
            ->latest('fecha_recepcion')
            ->get();

        return view('empresa-panel.denuncias.index', [
            'empresa' => $empresa,
            'denuncias' => $denuncias,
            'estadoActual' => $estado,
        ]);
    }

    public function show(Empresa $empresa, Denuncia $denuncia): View
    {
        abort_unless((int) $denuncia->empresa_id === (int) $empresa->id, 404);

        $denuncia->load(['causa', 'implicados', 'adjuntos']);

        return view('empresa-panel.denuncias.show', [
            'empresa' => $empresa,
            'denuncia' => $denuncia,
        ]);
    }

    public function update(Request $request, Empresa $empresa, Denuncia $denuncia): RedirectResponse
    {
        abort_unless((int) $denuncia->empresa_id === (int) $empresa->id, 404);

        $validated = $request->validate([
            'estado' => ['required', 'in:pendiente,en_revision,resuelta,archivada'],
        ]);

        $denuncia->update([
            'estado' => $validated['estado'],
        ]);

        return back()->with('status', 'Estado de la denuncia actualizado correctamente.');
    }

    public function downloadAttachment(Empresa $empresa, Denuncia $denuncia, DenunciaAdjunto $adjunto): StreamedResponse
    {
        abort_unless((int) $denuncia->empresa_id === (int) $empresa->id, 404);
        abort_unless((int) $adjunto->denuncia_id === (int) $denuncia->id, 404);
        abort_unless(Storage::disk('local')->exists($adjunto->ruta_archivo), 404);

        return Storage::disk('local')->download($adjunto->ruta_archivo, $adjunto->nombre_original);
    }
}
