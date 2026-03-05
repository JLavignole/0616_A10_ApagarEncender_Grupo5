<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $data = $this->buildDashboardData($request);

        return view('administrador.dashboard', $data);
    }

    public function dashboardIncidencias(Request $request): View
    {
        $data = $this->buildDashboardData($request);

        $kpiBaseQuery = Incidencia::query();
        if ($request->filled('sede')) {
            $kpiBaseQuery->where('sede_id', $request->input('sede'));
        }

        $totalIncidencias = (clone $kpiBaseQuery)->count();
        $totalIncidenciasResueltas = (clone $kpiBaseQuery)
            ->whereIn('estado', ['resuelta', 'cerrada'])
            ->count();
        $totalIncidenciasPendientes = (clone $kpiBaseQuery)
            ->whereIn('estado', ['sin_asignar', 'asignada', 'en_progreso', 'reabierta'])
            ->count();

        $desgloseQuery = Incidencia::query()
            ->select('tecnico_id', 'categoria_id', DB::raw('COUNT(*) as total'))
            ->with([
                'tecnico:id,nombre',
                'categoria:id,nombre',
            ])
            ->whereNotNull('tecnico_id')
            ->whereIn('estado', ['resuelta', 'cerrada'])
            ->groupBy('tecnico_id', 'categoria_id');

        if ($request->filled('buscar')) {
            $desgloseQuery->where('codigo', 'like', '%' . $request->input('buscar') . '%');
        }

        if ($request->filled('estado')) {
            $desgloseQuery->where('estado', $request->input('estado'));
        }

        if ($request->filled('prioridad')) {
            $desgloseQuery->where('prioridad', $request->input('prioridad'));
        }

        if ($request->filled('categoria')) {
            $desgloseQuery->where('categoria_id', $request->input('categoria'));
        }

        if ($request->filled('sede')) {
            $desgloseQuery->where('sede_id', $request->input('sede'));
        }

        if ($request->filled('fecha')) {
            $desgloseQuery->whereDate('reportado_en', $request->input('fecha'));
        }

        $desgloseIncidencias = $desgloseQuery
            ->orderByDesc('total')
            ->paginate(7)
            ->withQueryString();

        $data['totalIncidencias'] = $totalIncidencias;
        $data['totalIncidenciasResueltas'] = $totalIncidenciasResueltas;
        $data['totalIncidenciasPendientes'] = $totalIncidenciasPendientes;
        $data['desgloseIncidencias'] = $desgloseIncidencias;

        return view('administrador.resum.dashboard_incidencias', $data);
    }

    private function buildDashboardData(Request $request): array
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $totalUsuarios      = User::where('activo', true)->count();
        $totalIncidencias   = Incidencia::count();
        $incidenciasAbiertas = Incidencia::whereIn('estado', [
            'sin_asignar', 'asignada', 'en_progreso', 'reabierta',
        ])->count();

        $totalIncidenciasResueltas  = Incidencia::whereIn('estado', ['resuelta', 'cerrada'])->count();
        $totalIncidenciasPendientes = Incidencia::whereIn('estado', ['sin_asignar', 'asignada', 'en_progreso', 'reabierta'])->count();

        $query = Incidencia::with(['sede', 'cliente', 'tecnico', 'categoria']);

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
        $sedes              = Sede::where('activo', true)->orderBy('nombre')->get();
        $categorias         = Categoria::where('activo', true)->orderBy('nombre')->get();

        return compact(
            'usuario',
            'totalUsuarios',
            'totalIncidencias',
            'incidenciasAbiertas',
            'totalIncidenciasResueltas',
            'totalIncidenciasPendientes',
            'ultimasIncidencias',
            'sedes',
            'categorias',
        );
    }
}
