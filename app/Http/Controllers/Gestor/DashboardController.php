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
        $sedeId  = $usuario->sede_id;

        // KPIs filtrados por sede
        $incidenciasSinAsignar = Incidencia::where('sede_id', $sedeId)
            ->where('estado', 'sin_asignar')
            ->count();

        $incidenciasEnProgreso = Incidencia::where('sede_id', $sedeId)
            ->whereIn('estado', ['asignada', 'en_progreso'])
            ->count();

        $incidenciasResueltas = Incidencia::where('sede_id', $sedeId)
            ->where('estado', 'resuelta')
            ->count();

        $tecnicosActivos = User::where('sede_id', $sedeId)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->count();

        // Ultimas 10 incidencias sin asignar de la sede
        $pendientes = Incidencia::with(['cliente', 'categoria'])
            ->where('sede_id', $sedeId)
            ->where('estado', 'sin_asignar')
            ->oldest('reportado_en')
            ->take(10)
            ->get();

        // Técnicos de la sede (para el modal de asignación)
        $tecnicos = User::where('sede_id', $sedeId)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('gestor.dashboard', compact(
            'usuario',
            'incidenciasSinAsignar',
            'incidenciasEnProgreso',
            'incidenciasResueltas',
            'tecnicosActivos',
            'pendientes',
            'tecnicos',
        ));
    }
}
