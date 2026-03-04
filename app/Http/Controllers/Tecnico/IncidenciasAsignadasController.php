<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\Categoria; // Añade esto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenciasAsignadasController extends Controller
{
    public function index(Request $request)
    {
        $query = Incidencia::where('tecnico_id', Auth::id())
            ->with(['cliente', 'sede', 'categoria']);

        // --- LÓGICA DE FILTROS ---
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Orden y obtención de datos con paginación para que funcione ->total()
        $incidencias = $query->latest()->paginate(10);

        // Necesitamos enviar las categorías para el select del filtro
        $categorias = Categoria::all();

        return view('tecnico.incidencias.index', compact('incidencias', 'categorias'));
    }

    // Comenzar: de asignada a en_progreso
    public function comenzar(Incidencia $incidencia)
    {
        if ($incidencia->tecnico_id !== Auth::id()) abort(403);

        if ($incidencia->estado !== 'asignada') {
            return back()->with('error', 'La incidencia no está en estado "Asignada".');
        }

        $incidencia->update([
            'estado' => 'en_progreso'
        ]);

        return back()->with('exito', 'Has comenzado a trabajar en la incidencia.');
    }

    // De "En treball" a "Resolta" (resuelta)
    public function resolver(Incidencia $incidencia)
    {
        if ($incidencia->tecnico_id !== Auth::id()) abort(403);

        if ($incidencia->estado !== 'en_progreso') {
            return back()->with('error', 'La incidencia debe estar "En progreso" para resolverla.');
        }

        // Se quita la validación de comentario y se actualiza la fecha de resolución
        $incidencia->update([
            'estado' => 'resuelta',
            'resuelto_en' => now() 
        ]);

        return back()->with('exito', 'Incidencia marcada como Resuelta.');
    }

    public function show(Incidencia $incidencia)
    {
        // Verificamos que sea el técnico asignado. Solo el técnico asignado puede verla
        if ($incidencia->tecnico_id !== Auth::id()) abort(403);

        // Cargamos relaciones necesarias para el detalle
        $incidencia->load(['cliente', 'sede', 'mensajes.usuario', 'categoria', 'subcategoria']);

        return view('tecnico.incidencias.detalle', compact('incidencia'));
    }
}
