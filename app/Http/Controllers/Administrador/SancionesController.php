<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSancionRequest;
use App\Models\SancionUsuario;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SancionesController extends Controller
{
    // Listado con filtros
    public function index(Request $request): View
    {
        $query = SancionUsuario::with(['usuario', 'creadoPor']);

        if ($request->filled('tipo') && $request->input('tipo') !== 'todas') {
            $query->where('tipo', $request->input('tipo'));
        }

        $ahora  = now();
        $estado = $request->input('estado', 'todas');

        if ($estado === 'activas') {
            $query->where(function ($q) use ($ahora) {
                $q->whereNull('inicio_en')->orWhere('inicio_en', '<=', $ahora);
            })->where(function ($q) use ($ahora) {
                $q->whereNull('fin_en')->orWhere('fin_en', '>', $ahora);
            });
        } elseif ($estado === 'finalizadas') {
            $query->where(function ($q) use ($ahora) {
                $q->whereNotNull('fin_en')->where('fin_en', '<=', $ahora);
            });
        }

        if ($request->filled('buscar')) {
            $term = $request->input('buscar');
            $query->whereHas('usuario', function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('correo', 'like', "%{$term}%");
            });
        }

        $sanciones = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        $tipo      = $request->input('tipo', 'todas');

        return view('administrador.sanciones.index', compact('sanciones', 'tipo', 'estado'));
    }

    // Formulario de creación
    public function crear(): View
    {
        $usuarios = User::with('rol')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('administrador.sanciones.crear', compact('usuarios'));
    }

    // Guardar nueva sanción
    public function store(StoreSancionRequest $request): RedirectResponse
    {
        $data      = $request->validated();
        $adminId   = Auth::id();
        $usuarioId = $data['usuario_id'];
        $tipo      = $data['tipo'];

        // Regla: no sancionarse a sí mismo con bloqueo
        if ($tipo === 'bloqueo' && $usuarioId == $adminId) {
            return back()
                ->withInput()
                ->with('error', 'No puedes aplicarte un bloqueo a ti mismo.');
        }

        // Regla: no bloquear al último administrador activo
        if ($tipo === 'bloqueo') {
            $usuario = User::with('rol')->find($usuarioId);

            if (isset($usuario->rol->nombre) && in_array($usuario->rol->nombre, ['admin', 'administrador'])) {
                $totalAdmins = User::whereHas('rol', function ($q) {
                    $q->whereIn('nombre', ['admin', 'administrador']);
                })->where('activo', true)->count();

                if ($totalAdmins <= 1) {
                    return back()
                        ->withInput()
                        ->with('error', 'No puedes bloquear al único administrador activo del sistema.');
                }
            }
        }

        SancionUsuario::create([
            'usuario_id' => $usuarioId,
            'tipo'       => $tipo,
            'motivo'     => $data['motivo'],
            'inicio_en'  => $data['inicio_en'] ?? null,
            'fin_en'     => $data['fin_en'] ?? null,
            'creado_por' => $adminId,
        ]);

        $usuario = User::find($usuarioId);
        $nombre  = isset($usuario->nombre) ? $usuario->nombre : 'Usuario';

        return redirect()
            ->route('administrador.sanciones.index')
            ->with('exito', "Sanción aplicada a {$nombre} correctamente.");
    }

    // Finalizar sanción activa
    public function finalizar(SancionUsuario $sancion): RedirectResponse
    {
        $sancion->update(['fin_en' => now()]);

        $nombre = isset($sancion->usuario->nombre) ? $sancion->usuario->nombre : 'Usuario';

        return redirect()
            ->route('administrador.sanciones.index')
            ->with('exito', "Sanción de {$nombre} finalizada correctamente.");
    }
}
