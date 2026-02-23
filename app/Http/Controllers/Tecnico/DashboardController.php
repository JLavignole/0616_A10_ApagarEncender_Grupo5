<?php

namespace App\Http\Controllers\Tecnico;

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

        $asignadas    = Incidencia::where('tecnico_id', $usuario->id)
            ->whereIn('estado', ['asignada', 'en_progreso'])
            ->count();

        $enProgreso   = Incidencia::where('tecnico_id', $usuario->id)
            ->where('estado', 'en_progreso')
            ->count();

        $resueltasHoy = Incidencia::where('tecnico_id', $usuario->id)
            ->where('estado', 'resuelta')
            ->whereDate('updated_at', today())
            ->count();

        $misIncidencias = Incidencia::with(['sede', 'cliente'])
            ->where('tecnico_id', $usuario->id)
            ->whereIn('estado', ['asignada', 'en_progreso', 'reabierta'])
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view('tecnico.dashboard', compact(
            'usuario',
            'asignadas',
            'enProgreso',
            'resueltasHoy',
            'misIncidencias',
        ));
    }
}
