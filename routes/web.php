<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\Administrador\DashboardController as AdminDashboard;
use App\Http\Controllers\Gestor\DashboardController as GestorDashboard;
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
    // Dashboards por rol
    Route::get('/administrador/dashboard', [AdminDashboard::class,   'index'])->name('administrador.dashboard');
    Route::get('/gestor/dashboard',        [GestorDashboard::class,  'index'])->name('gestor.dashboard');
    Route::get('/tecnico/dashboard',       [TecnicoDashboard::class, 'index'])->name('tecnico.dashboard');
    Route::get('/cliente/dashboard',       [ClienteDashboard::class, 'index'])->name('cliente.dashboard');

    // Incidencias y otros
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
