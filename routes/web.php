<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminEmpresaController;
use App\Http\Controllers\CanalDenunciaController;
use App\Http\Controllers\EmpresaDenunciaController;
use App\Http\Controllers\EmpresaPanelAuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/canaldedenuncias');
Route::get('/canaldedenuncias', [CanalDenunciaController::class, 'landing'])->name('canal-denuncias.landing');

Route::prefix('/canaldedenuncias/admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/inicio', fn () => redirect()->route('admin.empresas.index'))->name('admin.home');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::get('/empresas', [AdminEmpresaController::class, 'index'])->name('admin.empresas.index');
        Route::get('/empresas/crear', [AdminEmpresaController::class, 'create'])->name('admin.empresas.create');
        Route::post('/empresas', [AdminEmpresaController::class, 'store'])->name('admin.empresas.store');
        Route::get('/empresas/{empresa}/estadisticas', [AdminEmpresaController::class, 'stats'])->name('admin.empresas.stats');
        Route::get('/empresas/{empresa}/editar', [AdminEmpresaController::class, 'edit'])->name('admin.empresas.edit');
        Route::put('/empresas/{empresa}', [AdminEmpresaController::class, 'update'])->name('admin.empresas.update');
        Route::delete('/empresas/{empresa}', [AdminEmpresaController::class, 'destroy'])->name('admin.empresas.destroy');
    });
});

Route::prefix('/canaldedenuncias/empresa/{empresa:dominio}')->group(function () {
    Route::get('/', fn ($empresa) => redirect()->route('empresa.panel.login', $empresa))
        ->name('empresa.panel.home');
    Route::get('/login', [EmpresaPanelAuthController::class, 'showLogin'])->name('empresa.panel.login');
    Route::post('/login', [EmpresaPanelAuthController::class, 'login'])->name('empresa.panel.login.submit');

    Route::middleware('empresa.panel.auth')->group(function () {
        Route::post('/logout', [EmpresaPanelAuthController::class, 'logout'])->name('empresa.panel.logout');
        Route::get('/denuncias', [EmpresaDenunciaController::class, 'index'])->name('empresa.panel.denuncias.index');
        Route::get('/denuncias/{denuncia}', [EmpresaDenunciaController::class, 'show'])->name('empresa.panel.denuncias.show');
        Route::get('/denuncias/{denuncia}/adjuntos/{adjunto}', [EmpresaDenunciaController::class, 'downloadAttachment'])
            ->name('empresa.panel.denuncias.adjuntos.download');
        Route::put('/denuncias/{denuncia}', [EmpresaDenunciaController::class, 'update'])->name('empresa.panel.denuncias.update');
    });
});

Route::prefix('/canaldedenuncias/{empresa:dominio}')
    ->where(['empresa' => '[A-Za-z0-9\-\.]+'])
    ->group(function () {
        Route::get('/', [CanalDenunciaController::class, 'show'])->name('canal-denuncias.show');
        Route::post('/', [CanalDenunciaController::class, 'store'])->name('canal-denuncias.store');
        Route::get('/confirmacion/{codigo}', [CanalDenunciaController::class, 'confirmation'])
            ->name('canal-denuncias.confirmacion');
        Route::post('/confirmacion/{codigo}/correo', [CanalDenunciaController::class, 'sendTrackingCode'])
            ->name('canal-denuncias.confirmacion.correo');
        Route::get('/seguimiento', [CanalDenunciaController::class, 'tracking'])
            ->name('canal-denuncias.tracking');
    });
