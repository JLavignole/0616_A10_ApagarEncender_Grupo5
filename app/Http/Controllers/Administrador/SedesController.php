<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSedeRequest;
use App\Http\Requests\Admin\UpdateSedeRequest;
use App\Models\Sede;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SedesController extends Controller
{
    // ── Listado con filtros ────────────────────────────
    public function index(Request $request): View
    {
        $query = Sede::query();

        // Filtro por estado
        $estado = $request->input('estado', 'todas');
        if ($estado === 'activas') {
            $query->where('activo', true);
        } elseif ($estado === 'inactivas') {
            $query->where('activo', false);
        }

        // Búsqueda por nombre o código
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

    // ── Formulario de creación ─────────────────────────
    public function crear(): View
    {
        return view('administrador.sedes.crear');
    }

    // ── Guardar nueva sede ─────────────────────────────
    public function store(StoreSedeRequest $request): RedirectResponse
    {
        Sede::create($request->validated());

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede «{$request->nombre}» creada correctamente.");
    }

    // ── Formulario de edición ──────────────────────────
    public function editar(Sede $sede): View
    {
        return view('administrador.sedes.editar', compact('sede'));
    }

    // ── Actualizar sede ────────────────────────────────
    public function update(UpdateSedeRequest $request, Sede $sede): RedirectResponse
    {
        $sede->update($request->validated());

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede «{$sede->nombre}» actualizada correctamente.");
    }

    // ── Activar sede ───────────────────────────────────
    public function activar(Sede $sede): RedirectResponse
    {
        $sede->update(['activo' => true]);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede «{$sede->nombre}» activada correctamente.");
    }

    // ── Desactivar sede ────────────────────────────────
    public function desactivar(Sede $sede): RedirectResponse
    {
        $sede->update(['activo' => false]);

        return redirect()
            ->route('administrador.sedes.index')
            ->with('exito', "Sede «{$sede->nombre}» desactivada. Los usuarios de esta sede no podrán registrarse ni crear incidencias.");
    }
}
