<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidenciaController;
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
    Route::get('/home', fn () => view('home'))->name('home');
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
