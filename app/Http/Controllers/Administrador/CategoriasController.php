<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriasController extends Controller
{
    /**
     * Listado con filtros
     */
    public function index(Request $request)
    {
        $query = Categoria::query();

        $estado = $request->input('estado', 'todas');
        if ($estado === 'activas') {
            $query->where('activo', true);
        } elseif ($estado === 'inactivas') {
            $query->where('activo', false);
        }

        if ($request->filled('buscar')) {
            $term = $request->input('buscar');
            $query->where('nombre', 'like', "%{$term}%");
        }

        $categorias = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('administrador.categorias.index', compact('categorias', 'estado'));
    }

    /**
     * Formulario de creación
     */
    public function crear()
    {
        return view('administrador.categorias.crear');
    }

    /**
     * Guardar nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:255', 'unique:categorias,nombre'],
            'activo' => ['nullable', 'boolean'],
        ]);

        Categoria::create($validated);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría {$request->nombre} creada correctamente.");
    }

    /**
     * Formulario de edición
     */
    public function editar(Categoria $categoria)
    {
        return view('administrador.categorias.editar', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:255', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'activo' => ['nullable', 'boolean'],
        ]);

        $categoria->update($validated);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría {$categoria->nombre} actualizada correctamente.");
    }

    /**
     * Activar categoría
     */
    public function activar(Categoria $categoria)
    {
        $categoria->update(['activo' => true]);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría {$categoria->nombre} activada correctamente.");
    }

    /**
     * Desactivar categoría
     */
    public function desactivar(Categoria $categoria)
    {
        $subcategoriasActivas = $categoria->subcategorias()->where('activo', true)->count();

        if ($subcategoriasActivas > 0) {
            return back()->with('error', "No puedes desactivar la categoría «{$categoria->nombre}» porque tiene {$subcategoriasActivas} subcategoría(s) activa(s). Desactívalas primero.");
        }

        $categoria->update(['activo' => false]);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» desactivada correctamente.");
    }
}