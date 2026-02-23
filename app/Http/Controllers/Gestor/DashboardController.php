<?php

namespace App\Http\Controllers\Gestor;

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

        $incidenciasSinAsignar = Incidencia::where('estado', 'sin_asignar')->count();
        $incidenciasEnProgreso = Incidencia::where('estado', 'en_progreso')->count();
        $tecnicosActivos       = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->count();

        $pendientes = Incidencia::with(['sede', 'cliente'])
            ->where('estado', 'sin_asignar')
            ->oldest('created_at')
            ->take(10)
            ->get();

        return view('gestor.dashboard', compact(
            'usuario',
            'incidenciasSinAsignar',
            'incidenciasEnProgreso',
            'tecnicosActivos',
            'pendientes',
        ));
    }
}
