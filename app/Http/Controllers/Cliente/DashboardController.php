<?php

namespace App\Http\Controllers\Cliente;

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

        $totalMisIncidencias = Incidencia::where('cliente_id', $usuario->id)->count();

        $incidenciasAbiertas = Incidencia::where('cliente_id', $usuario->id)
            ->whereIn('estado', ['sin_asignar', 'asignada', 'en_progreso', 'reabierta'])
            ->count();

        $incidenciasCerradas = Incidencia::where('cliente_id', $usuario->id)
            ->whereIn('estado', ['resuelta', 'cerrada'])
            ->count();

        $misIncidencias = Incidencia::with(['sede', 'tecnico'])
            ->where('cliente_id', $usuario->id)
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('cliente.dashboard', compact(
            'usuario',
            'totalMisIncidencias',
            'incidenciasAbiertas',
            'incidenciasCerradas',
            'misIncidencias',
        ));
    }
}
