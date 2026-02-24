<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\Administrador\DashboardController as AdminDashboard;
use App\Http\Controllers\Gestor\DashboardController as GestorDashboard;
use App\Http\Controllers\Gestor\IncidenciaGestorController;
use App\Http\Controllers\Gestor\TecnicoGestorController;
use App\Http\Controllers\Tecnico\DashboardController as TecnicoDashboard;
use App\Http\Controllers\Cliente\DashboardController as ClienteDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// ── Autenticación ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    // ── Módulo Administrador ────────────────────────────────────────
    Route::middleware('role:administrador')->prefix('administrador')->name('administrador.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    });

    // ── Módulo Gestor ───────────────────────────────────────────────
    Route::middleware('role:gestor')->prefix('gestor')->name('gestor.')->group(function () {
        Route::get('/dashboard', [GestorDashboard::class, 'index'])->name('dashboard');
        Route::get('/incidencias', [IncidenciaGestorController::class, 'index'])->name('incidencias');
        Route::get('/incidencias/{id}', [IncidenciaGestorController::class, 'show'])->name('incidencias.show');
        Route::post('/incidencias/{id}/asignar', [IncidenciaGestorController::class, 'asignar'])->name('incidencias.asignar');
        Route::get('/tecnicos', [TecnicoGestorController::class, 'index'])->name('tecnicos');
    });

    // ── Módulo Técnico ──────────────────────────────────────────────
    Route::middleware('role:tecnico')->prefix('tecnico')->name('tecnico.')->group(function () {
        Route::get('/dashboard', [TecnicoDashboard::class, 'index'])->name('dashboard');
    });

    // ── Módulo Cliente ──────────────────────────────────────────────
    Route::middleware('role:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', [ClienteDashboard::class, 'index'])->name('dashboard');
    });

    // ── Incidencias (accesible por múltiples roles) ─────────────────
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

    // ── Cerrar sesión ───────────────────────────────────────────────
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
