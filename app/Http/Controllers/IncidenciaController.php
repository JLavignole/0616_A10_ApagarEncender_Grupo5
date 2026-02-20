<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncidenciaController extends Controller
{
    /**
     * Listado de incidencias con filtros opcionales.
     */
    public function index(Request $request): View
    {
        $query = Incidencia::with(['categoria', 'subcategoria', 'cliente', 'tecnico', 'sede']);

        // Filtro por búsqueda (título o código)
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro por prioridad
        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $incidencias = $query->orderByDesc('reportado_en')->paginate(10)->withQueryString();
        $categorias  = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('incidencias.index', compact('incidencias', 'categorias'));
    }
}
