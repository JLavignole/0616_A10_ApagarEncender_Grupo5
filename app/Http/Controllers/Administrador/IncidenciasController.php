<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncidenciasController extends Controller
{
    /**
     * Listado global de incidencias (todas las sedes).
     */
    public function index(Request $request): View
    {
        $query = Incidencia::with(['sede', 'cliente', 'tecnico', 'categoria']);

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        if ($request->filled('sede_id')) {
            $query->where('sede_id', $request->input('sede_id'));
        }

        $orden = $request->input('orden', 'fecha_desc');
        if ($orden === 'fecha_asc') {
            $query->oldest('reportado_en');
        } else {
            $query->latest('reportado_en');
        }

        $incidencias = $query->paginate(7)->withQueryString();
        $sedes       = Sede::orderBy('nombre')->get();

        return view('administrador.incidencias.index', compact('incidencias', 'sedes'));
    }

    /**
     * Formulario de edición completa (todos los campos).
     */
    public function editar(Incidencia $incidencia): View
    {
        $incidencia->load(['categoria', 'subcategoria', 'tecnico', 'gestor', 'sede', 'cliente']);

        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $sedes      = Sede::where('activo', true)->orderBy('nombre')->get();

        $tecnicos = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $gestores = User::whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('administrador.incidencias.editar',
            compact('incidencia', 'categorias', 'sedes', 'tecnicos', 'gestores'));
    }

    /**
     * Actualizar todos los campos de la incidencia.
     * Usa transacción para garantizar consistencia.
     */
    public function update(Request $request, Incidencia $incidencia): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'          => ['required', 'string', 'max:255'],
            'descripcion'     => ['required', 'string'],
            'estado'          => ['required', 'in:sin_asignar,asignada,en_progreso,resuelta,cerrada,reabierta'],
            'prioridad'       => ['nullable', 'in:alta,media,baja'],
            'categoria_id'    => ['required', 'exists:categorias,id'],
            'subcategoria_id' => ['required', 'exists:subcategorias,id'],
            'sede_id'         => ['required', 'exists:sedes,id'],
            'tecnico_id'      => ['nullable', 'exists:usuarios,id'],
            'gestor_id'       => ['nullable', 'exists:usuarios,id'],
        ], [
            'titulo.required'          => 'El título es obligatorio.',
            'titulo.max'               => 'El título no puede superar los 255 caracteres.',
            'descripcion.required'     => 'La descripción es obligatoria.',
            'estado.required'          => 'El estado es obligatorio.',
            'estado.in'                => 'El estado seleccionado no es válido.',
            'prioridad.in'             => 'La prioridad seleccionada no es válida.',
            'categoria_id.required'    => 'Selecciona una categoría.',
            'categoria_id.exists'      => 'La categoría seleccionada no es válida.',
            'subcategoria_id.required' => 'Selecciona una subcategoría.',
            'subcategoria_id.exists'   => 'La subcategoría seleccionada no es válida.',
            'sede_id.required'         => 'Selecciona una sede.',
            'sede_id.exists'           => 'La sede seleccionada no es válida.',
            'tecnico_id.exists'        => 'El técnico seleccionado no es válido.',
            'gestor_id.exists'         => 'El gestor seleccionado no es válido.',
        ]);

        DB::beginTransaction();

        try {
            $incidencia->update([
                'titulo'          => $validated['titulo'],
                'descripcion'     => $validated['descripcion'],
                'estado'          => $validated['estado'],
                'prioridad'       => $validated['prioridad'] ?? null,
                'categoria_id'    => $validated['categoria_id'],
                'subcategoria_id' => $validated['subcategoria_id'],
                'sede_id'         => $validated['sede_id'],
                'tecnico_id'      => $validated['tecnico_id'] ?? null,
                'gestor_id'       => $validated['gestor_id'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('administrador.incidencias.index')
                ->with('exito', 'Incidencia ' . $incidencia->codigo . ' actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la incidencia. Inténtalo de nuevo.');
        }
    }
}
