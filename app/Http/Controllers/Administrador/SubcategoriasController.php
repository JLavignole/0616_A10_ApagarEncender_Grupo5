<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubcategoriaRequest;
use App\Http\Requests\Admin\UpdateSubcategoriaRequest;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubcategoriasController extends Controller
{
    // Listado con filtros
    public function index(Request $request): View
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

        $subcategorias = $query->orderBy('nombre')->paginate(10)->withQueryString();
        $categorias    = Categoria::orderBy('nombre')->get();

        return view('administrador.subcategorias.index', compact('subcategorias', 'categorias', 'estado'));
    }

    // Formulario de creación
    public function crear(): View
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('administrador.subcategorias.crear', compact('categorias'));
    }

    // Guardar nueva subcategoría
    public function store(StoreSubcategoriaRequest $request): RedirectResponse
    {
        Subcategoria::create($request->validated());

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría «{$request->nombre}» creada correctamente.");
    }

    // Formulario de edición
    public function editar(Subcategoria $subcategoria): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('administrador.subcategorias.editar', compact('subcategoria', 'categorias'));
    }

    // Actualizar subcategoría
    public function update(UpdateSubcategoriaRequest $request, Subcategoria $subcategoria): RedirectResponse
    {
        $subcategoria->update($request->validated());

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría «{$subcategoria->nombre}» actualizada correctamente.");
    }

    // Activar subcategoría
    public function activar(Subcategoria $subcategoria): RedirectResponse
    {
        $subcategoria->update(['activo' => true]);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría «{$subcategoria->nombre}» activada correctamente.");
    }

    // Desactivar subcategoría
    public function desactivar(Subcategoria $subcategoria): RedirectResponse
    {
        $subcategoria->update(['activo' => false]);

        return redirect()
            ->route('administrador.subcategorias.index')
            ->with('exito', "Subcategoría «{$subcategoria->nombre}» desactivada correctamente.");
    }

    // Endpoint JSON: subcategorías activas de una categoría
    public function porCategoria(int $id): JsonResponse
    {
        $subcategorias = Subcategoria::where('categoria_id', $id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($subcategorias);
    }
}
