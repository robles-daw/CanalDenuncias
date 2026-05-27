<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresaPanelAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $empresa = $request->route('empresa');
        $empresaId = $request->session()->get('empresa_panel_id');

        if (! $empresa instanceof Empresa || ! $empresaId || (int) $empresaId !== (int) $empresa->id) {
            return redirect()->route('empresa.panel.login', $empresa?->dominio);
        }

        return $next($request);
    }
}
