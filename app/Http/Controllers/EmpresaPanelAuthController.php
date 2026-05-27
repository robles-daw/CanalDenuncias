<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpresaPanelAuthController extends Controller
{
    public function showLogin(Empresa $empresa): View|RedirectResponse
    {
        if ((int) session('empresa_panel_id') === (int) $empresa->id) {
            return redirect()->route('empresa.panel.denuncias.index', $empresa->dominio);
        }

        return view('empresa-panel.auth.login', [
            'empresa' => $empresa,
        ]);
    }

    public function login(Request $request, Empresa $empresa): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (
            $credentials['email'] !== $empresa->email ||
            ! $empresa->password ||
            ! Hash::check($credentials['password'], $empresa->password)
        ) {
            return back()
                ->withErrors([
                    'email' => 'Las credenciales no son válidas.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('empresa_panel_id', $empresa->id);
        $request->session()->put('empresa_panel_nombre', $empresa->nombre);

        return redirect()->route('empresa.panel.denuncias.index', $empresa->dominio);
    }

    public function logout(Request $request, Empresa $empresa): RedirectResponse
    {
        $request->session()->forget([
            'empresa_panel_id',
            'empresa_panel_nombre',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('empresa.panel.login', $empresa->dominio);
    }
}
