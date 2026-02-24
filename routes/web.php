<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\Administrador\DashboardController as AdminDashboard;
use App\Http\Controllers\Administrador\SedesController;
use App\Http\Controllers\Administrador\UsuariosController;
use App\Http\Controllers\Administrador\CategoriasController;
use App\Http\Controllers\Administrador\SubcategoriasController;
use App\Http\Controllers\Administrador\SancionesController;
use App\Http\Controllers\Gestor\DashboardController as GestorDashboard;
use App\Http\Controllers\Tecnico\DashboardController as TecnicoDashboard;
use App\Http\Controllers\Cliente\DashboardController as ClienteDashboard;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    // Rutas del módulo Administrador
    Route::middleware('role:administrador')->prefix('administrador')->name('administrador.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Gestión de usuarios
        Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UsuariosController::class, 'crear'])->name('usuarios.crear');
        Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}/editar', [UsuariosController::class, 'editar'])->name('usuarios.editar');
        Route::put('/usuarios/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
        Route::post('/usuarios/{usuario}/desactivar', [UsuariosController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::post('/usuarios/{usuario}/reactivar', [UsuariosController::class, 'reactivar'])->name('usuarios.reactivar');

        // Gestión de categorías
        Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/crear', [CategoriasController::class, 'crear'])->name('categorias.crear');
        Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}/editar', [CategoriasController::class, 'editar'])->name('categorias.editar');
        Route::put('/categorias/{categoria}', [CategoriasController::class, 'update'])->name('categorias.update');
        Route::post('/categorias/{categoria}/activar', [CategoriasController::class, 'activar'])->name('categorias.activar');
        Route::post('/categorias/{categoria}/desactivar', [CategoriasController::class, 'desactivar'])->name('categorias.desactivar');

        // Gestión de subcategorías
        Route::get('/subcategorias/por-categoria/{id}', [SubcategoriasController::class, 'porCategoria'])->name('subcategorias.porCategoria');
        Route::get('/subcategorias', [SubcategoriasController::class, 'index'])->name('subcategorias.index');
        Route::get('/subcategorias/crear', [SubcategoriasController::class, 'crear'])->name('subcategorias.crear');
        Route::post('/subcategorias', [SubcategoriasController::class, 'store'])->name('subcategorias.store');
        Route::get('/subcategorias/{subcategoria}/editar', [SubcategoriasController::class, 'editar'])->name('subcategorias.editar');
        Route::put('/subcategorias/{subcategoria}', [SubcategoriasController::class, 'update'])->name('subcategorias.update');
        Route::post('/subcategorias/{subcategoria}/activar', [SubcategoriasController::class, 'activar'])->name('subcategorias.activar');
        Route::post('/subcategorias/{subcategoria}/desactivar', [SubcategoriasController::class, 'desactivar'])->name('subcategorias.desactivar');

        // Gestión de sanciones
        Route::get('/sanciones', [SancionesController::class, 'index'])->name('sanciones.index');
        Route::get('/sanciones/crear', [SancionesController::class, 'crear'])->name('sanciones.crear');
        Route::post('/sanciones', [SancionesController::class, 'store'])->name('sanciones.store');
        Route::post('/sanciones/{sancion}/finalizar', [SancionesController::class, 'finalizar'])->name('sanciones.finalizar');

        // Gestión de sedes
        Route::get('/sedes', [SedesController::class, 'index'])->name('sedes.index');
        Route::get('/sedes/crear', [SedesController::class, 'crear'])->name('sedes.crear');
        Route::post('/sedes', [SedesController::class, 'store'])->name('sedes.store');
        Route::get('/sedes/{sede}/editar', [SedesController::class, 'editar'])->name('sedes.editar');
        Route::put('/sedes/{sede}', [SedesController::class, 'update'])->name('sedes.update');
        Route::post('/sedes/{sede}/activar', [SedesController::class, 'activar'])->name('sedes.activar');
        Route::post('/sedes/{sede}/desactivar', [SedesController::class, 'desactivar'])->name('sedes.desactivar');
    });

    // Rutas del módulo Gestor
    Route::middleware('role:gestor')->prefix('gestor')->name('gestor.')->group(function () {
        Route::get('/dashboard', [GestorDashboard::class, 'index'])->name('dashboard');
    });

    // Rutas del módulo Técnico
    Route::middleware('role:tecnico')->prefix('tecnico')->name('tecnico.')->group(function () {
        Route::get('/dashboard', [TecnicoDashboard::class, 'index'])->name('dashboard');
    });

    // Rutas del módulo Cliente
    Route::middleware('role:cliente')->prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/dashboard', [ClienteDashboard::class, 'index'])->name('dashboard');
    });

    // Incidencias (accesible por múltiples roles)
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
