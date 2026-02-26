<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubcategoriasController extends Controller
{
    /**
     * Listado con filtros
     */
    public function index(Request $request)
    {
        $query = Subcategoria::with('categoria');

        $estado = $request->input('estado', 'todas');
        if ($estado === 'activas') {
            $query->where('activo', true);
        } elseif ($estado === 'inactivas') {
            $query->where('activo', false);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        if ($request->filled('buscar')) {
            $term = $request->input('buscar');
            $query->where('nombre', 'like', "%{$term}%");
        }

        $subcategorias = $query->orderBy('nombre')->paginate(7)->withQueryString();
        $categorias    = Categoria::orderBy('nombre')->get();

        return view('administrador.subcategorias.index', compact('subcategorias', 'categorias', 'estado'));
    }

    /**
     * Formulario de creación
     */
    public function crear()
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('administrador.subcategorias.crear', compact('categorias'));
    }

    /**
     * Guardar nueva subcategoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'nombre'       => [
                'required', 'string', 'min:2', 'max:255',
                Rule::unique('subcategorias', 'nombre')->where('categoria_id', $request->input('categoria_id')),
            ],
            'activo' => ['nullable', 'boolean'],
        ]);

        Subcategoria::create($validated);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría {$request->nombre} creada correctamente.");
    }

    /**
     * Formulario de edición
     */
    public function editar(Subcategoria $subcategoria)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('administrador.subcategorias.editar', compact('subcategoria', 'categorias'));
    }

    /**
     * Actualizar subcategoría
     */
    public function update(Request $request, Subcategoria $subcategoria)
    {
        $validated = $request->validate([
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'nombre'       => [
                'required', 'string', 'min:2', 'max:255',
                Rule::unique('subcategorias', 'nombre')
                    ->where('categoria_id', $request->input('categoria_id'))
                    ->ignore($subcategoria->id),
            ],
            'activo' => ['nullable', 'boolean'],
        ]);

        $subcategoria->update($validated);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría {$subcategoria->nombre} actualizada correctamente.");
    }

    /**
     * Activar subcategoría
     */
    public function activar(Subcategoria $subcategoria)
    {
        $subcategoria->update(['activo' => true]);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría {$subcategoria->nombre} activada correctamente.");
    }

    /**
     * Desactivar subcategoría
     */
    public function desactivar(Subcategoria $subcategoria)
    {
        $subcategoria->update(['activo' => false]);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría {$subcategoria->nombre} desactivada correctamente.");
    }

    /**
     * Endpoint JSON: subcategorías activas de una categoría
     */
    public function porCategoria($id)
    {
        $subcategorias = Subcategoria::where('categoria_id', $id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($subcategorias);
    }
}