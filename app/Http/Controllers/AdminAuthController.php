<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('admin_user_id')) {
            return redirect()->route('admin.empresas.index');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $adminUser = AdminUser::query()
            ->where('email', $credentials['email'])
            ->first();

        if (! $adminUser || ! Hash::check($credentials['password'], $adminUser->password)) {
            return back()
                ->withErrors([
                    'email' => 'Las credenciales no son válidas.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_user_id', $adminUser->id);
        $request->session()->put('admin_user_name', $adminUser->name);

        return redirect()->route('admin.empresas.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'admin_user_id',
            'admin_user_name',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
