<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SedesController extends Controller
{
    /**
     * Listado con filtros
     */
    public function index(Request $request)
    {
        $query = Sede::query();

        $estado = $request->input('estado', 'todas');
        if ($estado === 'activas') {
            $query->where('activo', true);
        } elseif ($estado === 'inactivas') {
            $query->where('activo', false);
        }

        if ($request->filled('buscar')) {
            $term = $request->input('buscar');
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('codigo', 'like', "%{$term}%");
            });
        }

        $sedes = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('administrador.sedes.index', compact('sedes', 'estado'));
    }

    /**
     * Formulario de creación
     */
    public function crear()
    {
        return view('administrador.sedes.crear');
    }

    /**
     * Guardar nueva sede
     */
    public function store(Request $request)
    {
        $request->merge(['codigo' => strtoupper(trim($request->codigo))]);

        $validated = $request->validate([
            'codigo'       => ['required', 'string', 'min:2', 'max:5', 'regex:/^[A-Z]+$/', 'unique:sedes,codigo'],
            'nombre'       => ['required', 'string', 'max:255'],
            'zona_horaria' => ['nullable', 'string', 'max:80'],
            'activo'       => ['sometimes', 'boolean'],
        ]);

        Sede::create($validated);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede {$request->nombre} creada correctamente.");
    }

    /**
     * Formulario de edición
     */
    public function editar(Sede $sede)
    {
        return view('administrador.sedes.editar', compact('sede'));
    }

    /**
     * Actualizar sede
     */
    public function update(Request $request, Sede $sede)
    {
        $request->merge(['codigo' => strtoupper(trim($request->codigo))]);

        $validated = $request->validate([
            'codigo'       => ['required', 'string', 'min:2', 'max:5', 'regex:/^[A-Z]+$/', Rule::unique('sedes', 'codigo')->ignore($sede->id)],
            'nombre'       => ['required', 'string', 'max:255'],
            'zona_horaria' => ['nullable', 'string', 'max:80'],
            'activo'       => ['sometimes', 'boolean'],
        ]);

        $sede->update($validated);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede {$sede->nombre} actualizada correctamente.");
    }

    /**
     * Activar sede
     */
    public function activar(Sede $sede)
    {
        $sede->update(['activo' => true]);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede {$sede->nombre} activada correctamente.");
    }

    /**
     * Desactivar sede
     */
    public function desactivar(Sede $sede)
    {
        $sede->update(['activo' => false]);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede {$sede->nombre} desactivada. Los usuarios de esta sede no podrán registrarse ni crear incidencias.");
    }
}