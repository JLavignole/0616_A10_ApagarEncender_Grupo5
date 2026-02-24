<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $totalMisIncidencias = Incidencia::where('cliente_id', $usuario->id)->count();

        // Conteo por estado para el pipeline visual
        $sinAsignar = Incidencia::where('cliente_id', $usuario->id)->where('estado', 'sin_asignar')->count();
        $asignadas  = Incidencia::where('cliente_id', $usuario->id)->where('estado', 'asignada')->count();
        $enProgreso = Incidencia::where('cliente_id', $usuario->id)->where('estado', 'en_progreso')->count();
        $resueltas  = Incidencia::where('cliente_id', $usuario->id)->where('estado', 'resuelta')->count();
        $cerradas   = Incidencia::where('cliente_id', $usuario->id)->where('estado', 'cerrada')->count();

        $incidenciasAbiertas = $sinAsignar + $asignadas + $enProgreso;

        // Últimas 4 incidencias activas como tarjetas
        $recientes = Incidencia::with(['tecnico', 'categoria'])
            ->where('cliente_id', $usuario->id)
            ->where('estado', '!=', 'cerrada')
            ->latest('reportado_en')
            ->take(4)
            ->get();

        return view('cliente.dashboard', compact(
            'usuario',
            'totalMisIncidencias',
            'incidenciasAbiertas',
            'sinAsignar',
            'asignadas',
            'enProgreso',
            'resueltas',
            'cerradas',
            'recientes',
        ));
    }
}
