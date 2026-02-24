<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\Administrador\DashboardController as AdminDashboard;
use App\Http\Controllers\Gestor\DashboardController as GestorDashboard;
use App\Http\Controllers\Tecnico\DashboardController as TecnicoDashboard;
use App\Http\Controllers\Cliente\DashboardController as ClienteDashboard;
use App\Http\Controllers\Cliente\IncidenciaController as ClienteIncidencia;
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

    // ── Cliente: Gestión de incidencias ─────────────────
    Route::prefix('cliente')->group(function () {
        Route::get('/incidencias',              [ClienteIncidencia::class, 'index'])->name('cliente.incidencias.index');
        Route::get('/incidencias/crear',        [ClienteIncidencia::class, 'create'])->name('cliente.incidencias.crear');
        Route::post('/incidencias',             [ClienteIncidencia::class, 'store'])->name('cliente.incidencias.store');
        Route::get('/incidencias/{incidencia}', [ClienteIncidencia::class, 'show'])->name('cliente.incidencias.detalle');
        Route::post('/incidencias/{incidencia}/mensajes', [ClienteIncidencia::class, 'sendMessage'])->name('cliente.incidencias.mensaje');
        Route::patch('/incidencias/{incidencia}/cerrar', [ClienteIncidencia::class, 'close'])->name('cliente.incidencias.cerrar');
    });

    // ── AJAX: Subcategorías por categoría ───────────────
    Route::get('/api/categorias/{categoria}/subcategorias', [ClienteIncidencia::class, 'subcategorias'])->name('api.subcategorias');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
