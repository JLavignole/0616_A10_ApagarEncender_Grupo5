<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $totalUsuarios     = User::where('activo', true)->count();
        $totalIncidencias  = Incidencia::count();
        $incidenciasAbiertas = Incidencia::whereIn('estado', [
            'sin_asignar', 'asignada', 'en_progreso', 'reabierta',
        ])->count();

        $query = Incidencia::with(['sede', 'cliente']);

        if ($request->filled('buscar')) {
            $query->where('codigo', 'like', '%' . $request->input('buscar') . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        if ($request->filled('sede')) {
            $query->where('sede_id', $request->input('sede'));
        }

        if ($request->filled('fecha')) {
            $query->whereDate('reportado_en', $request->input('fecha'));
        }

        $ultimasIncidencias = $query->latest('created_at')->paginate(7)->withQueryString();

        $sedes = Sede::where('activo', true)->orderBy('nombre')->get();

        return view('administrador.dashboard', compact(
            'usuario',
            'totalUsuarios',
            'totalIncidencias',
            'incidenciasAbiertas',
            'ultimasIncidencias',
            'sedes',
        ));
    }
}
