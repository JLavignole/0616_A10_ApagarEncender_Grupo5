<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsuarioRequest;
use App\Http\Requests\Admin\UpdateUsuarioRequest;
use App\Models\Incidencia;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    // Listado con filtros
    public function index(Request $request): View
    {
        $query = User::with(['sede', 'rol'])->orderBy('nombre');

        // Filtro por sede
        if ($request->filled('sede_id')) {
            $query->where('sede_id', $request->input('sede_id'));
        }

        // Filtro por rol
        if ($request->filled('rol_id')) {
            $query->where('rol_id', $request->input('rol_id'));
        }

        // Filtro por estado activo
        $estado = $request->input('estado', 'todos');
        if ($estado === 'activos') {
            $query->where('activo', true);
        } elseif ($estado === 'inactivos') {
            $query->where('activo', false);
        }

        // Búsqueda por nombre o correo
        if ($request->filled('buscar')) {
            $term = $request->input('buscar');
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('correo', 'like', "%{$term}%");
            });
        }

        $usuarios = $query->paginate(15)->withQueryString();
        $sedes    = Sede::orderBy('nombre')->get();
        $roles    = Rol::orderBy('nombre')->get();

        return view('administrador.usuarios.index', compact('usuarios', 'sedes', 'roles', 'estado'));
    }

    // Formulario de creación
    public function crear(): View
    {
        $sedes = Sede::where('activo', true)->orderBy('nombre')->get();
        $roles = Rol::orderBy('nombre')->get();

        return view('administrador.usuarios.crear', compact('sedes', 'roles'));
    }

    // Guardar nuevo usuario
    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        User::create([
            'sede_id'    => $request->sede_id,
            'rol_id'     => $request->rol_id,
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'contrasena' => $request->contrasena,
            'activo'     => $request->boolean('activo', true),
        ]);

        return redirect()
            ->route('administrador.usuarios.index')
            ->with('exito', "Usuario «{$request->nombre}» creado correctamente.");
    }

    // Formulario de edición
    public function editar(User $usuario): View
    {
        $sedes = Sede::where('activo', true)->orderBy('nombre')->get();
        $roles = Rol::orderBy('nombre')->get();

        return view('administrador.usuarios.editar', compact('usuario', 'sedes', 'roles'));
    }

    // Actualizar usuario
    public function update(UpdateUsuarioRequest $request, User $usuario): RedirectResponse
    {
        $datos = [
            'sede_id' => $request->sede_id,
            'rol_id'  => $request->rol_id,
            'nombre'  => $request->nombre,
            'correo'  => $request->correo,
            'activo'  => $request->boolean('activo', true),
        ];

        if ($request->filled('contrasena')) {
            $datos['contrasena'] = $request->contrasena;
        }

        $usuario->update($datos);

        return redirect()
            ->route('administrador.usuarios.index')
            ->with('exito', "Usuario «{$usuario->nombre}» actualizado correctamente.");
    }

    // Desactivar usuario
    public function desactivar(User $usuario): RedirectResponse
    {
        $rolNombre = $usuario->rol?->nombre;

        // Regla: admin no puede desactivarse a sí mismo
        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        // Regla: no dejar el sistema sin admins activos
        if ($rolNombre === 'administrador') {
            $adminsActivos = User::whereHas('rol', function ($q) {
                $q->where('nombre', 'administrador');
            })->where('activo', true)->count();

            if ($adminsActivos <= 1) {
                return back()->with('error', 'No puedes desactivar al único administrador activo del sistema.');
            }
        }

        // Regla: técnico con incidencias asignadas o en progreso
        if ($rolNombre === 'tecnico') {
            $incidenciasActivas = Incidencia::where('tecnico_id', $usuario->id)
                ->whereIn('estado', ['asignada', 'en_progreso'])
                ->count();

            if ($incidenciasActivas > 0) {
                return back()->with('error', "No se puede desactivar al técnico «{$usuario->nombre}» porque tiene {$incidenciasActivas} incidencia(s) asignada(s) o en progreso. Reasígnalas antes de continuar.");
            }
        }

        // Regla: gestor único activo de su sede
        if ($rolNombre === 'gestor') {
            $gestoresActivosSede = User::whereHas('rol', function ($q) {
                $q->where('nombre', 'gestor');
            })->where('sede_id', $usuario->sede_id)
              ->where('activo', true)
              ->count();

            if ($gestoresActivosSede <= 1) {
                return back()->with('error', "No puedes desactivar a «{$usuario->nombre}» porque es el único gestor activo de su sede.");
            }
        }

        $usuario->update(['activo' => false]);

        return redirect()
            ->route('administrador.usuarios.index')
            ->with('exito', "Usuario «{$usuario->nombre}» desactivado correctamente.");
    }

    // Reactivar usuario
    public function reactivar(User $usuario): RedirectResponse
    {
        $usuario->update(['activo' => true]);

        return redirect()
            ->route('administrador.usuarios.index')
            ->with('exito', "Usuario «{$usuario->nombre}» reactivado correctamente.");
    }
}
