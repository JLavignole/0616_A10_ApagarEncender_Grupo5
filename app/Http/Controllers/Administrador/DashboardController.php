<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $totalUsuarios     = User::where('activo', true)->count();
        $totalIncidencias  = Incidencia::count();
        $incidenciasAbiertas = Incidencia::whereIn('estado', [
            'sin_asignar', 'asignada', 'en_progreso', 'reabierta',
        ])->count();

        $ultimasIncidencias = Incidencia::with(['sede', 'cliente'])
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('administrador.dashboard', compact(
            'usuario',
            'totalUsuarios',
            'totalIncidencias',
            'incidenciasAbiertas',
            'ultimasIncidencias',
        ));
    }
}
