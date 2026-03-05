<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumController extends Controller
{
    public function index(Request $request): View
    {
        $sedes      = Sede::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        $queryResueltas  = Incidencia::where('estado', 'resuelta');
        $queryPendientes = Incidencia::whereIn('estado', ['sin_asignar', 'asignada', 'en_progreso', 'reabierta']);

        if ($request->filled('sede_id')) {
            $queryResueltas->where('sede_id', $request->input('sede_id'));
            $queryPendientes->where('sede_id', $request->input('sede_id'));
        }

        $totalResueltas  = $queryResueltas->count();
        $totalPendientes = $queryPendientes->count();

        // Tecnicos con contador de incidencias por categoría
        $tecnicos = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->orderBy('nombre')
            ->get();

        $incidenciasQuery = Incidencia::selectRaw('tecnico_id, categoria_id, COUNT(*) as total')
            ->whereNotNull('tecnico_id')
            ->groupBy('tecnico_id', 'categoria_id');

        if ($request->filled('sede_id')) {
            $incidenciasQuery->where('sede_id', $request->input('sede_id'));
        }

        // Agrupar tecnico_id categoria_id total
        $conteos = $incidenciasQuery->get()->groupBy('tecnico_id')->map(function ($rows) {
            // pluck es para convertir la variable en un array
            return $rows->pluck('total', 'categoria_id');
        });

        return view('administrador.resum', compact(
            'sedes',
            'categorias',
            'totalResueltas',
            'totalPendientes',
            'tecnicos',
            'conteos',
        ));
    }
}
