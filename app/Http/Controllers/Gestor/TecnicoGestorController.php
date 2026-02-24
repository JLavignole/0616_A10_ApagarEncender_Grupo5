<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TecnicoGestorController extends Controller
{
    /**
     * Carga de trabajo por técnico de la sede.
     */
    public function index(): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();
        $sedeId  = $usuario->sede_id;

        // Técnicos de la sede con sus incidencias activas
        $tecnicos = User::where('sede_id', $sedeId)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->with(['incidenciasTecnico' => function ($q) {
                $q->whereIn('estado', ['asignada', 'en_progreso'])
                  ->with(['categoria'])
                  ->orderByRaw("FIELD(prioridad, 'alta', 'media', 'baja')")
                  ->oldest('reportado_en');
            }])
            ->orderBy('nombre')
            ->get();

        return view('gestor.tecnicos', compact('usuario', 'tecnicos'));
    }
}
