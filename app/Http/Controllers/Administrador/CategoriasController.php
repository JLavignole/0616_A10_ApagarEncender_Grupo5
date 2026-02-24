<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriaRequest;
use App\Http\Requests\Admin\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriasController extends Controller
{
    // Listado con filtros
    public function index(Request $request): View
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

    // Formulario de creación
    public function crear(): View
    {
        return view('administrador.categorias.crear');
    }

    // Guardar nueva categoría
    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría «{$request->nombre}» creada correctamente.");
    }

    // Formulario de edición
    public function editar(Categoria $categoria): View
    {
        return view('administrador.categorias.editar', compact('categoria'));
    }

    // Actualizar categoría
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» actualizada correctamente.");
    }

    // Activar categoría
    public function activar(Categoria $categoria): RedirectResponse
    {
        $categoria->update(['activo' => true]);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» activada correctamente.");
    }

    // Desactivar categoría
    public function desactivar(Categoria $categoria): RedirectResponse
    {
        $categoria->update(['activo' => false]);

        return redirect()
            ->route('administrador.categorias.index')
            ->with('exito', "Categoría «{$categoria->nombre}» desactivada correctamente.");
    }
}
