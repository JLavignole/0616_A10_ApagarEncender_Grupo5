<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncidenciaGestorController extends Controller
{
    /**
     * Listado de incidencias de la sede del gestor con filtros.
     */
    public function index(Request $request): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();
        $sedeId  = $usuario->sede_id;

        $query = Incidencia::with(['cliente', 'tecnico', 'categoria', 'subcategoria'])
            ->where('sede_id', $sedeId);

        // Filtro por búsqueda (título o código)
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro por prioridad
        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        // Ordenación
        $orden = $request->input('orden', 'fecha_desc');
        switch ($orden) {
            case 'prioridad_asc':
                $query->orderByRaw("FIELD(prioridad, 'alta', 'media', 'baja')");
                break;
            case 'prioridad_desc':
                $query->orderByRaw("FIELD(prioridad, 'baja', 'media', 'alta')");
                break;
            case 'fecha_asc':
                $query->oldest('reportado_en');
                break;
            default: // fecha_desc
                $query->latest('reportado_en');
                break;
        }

        $incidencias = $query->paginate(10)->withQueryString();

        // Técnicos de la sede (para el modal de asignación)
        $tecnicos = User::where('sede_id', $sedeId)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('gestor.incidencias', compact('usuario', 'incidencias', 'tecnicos'));
    }

    /**
     * Detalle completo de una incidencia de la sede.
     */
    public function show(int $id): View
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $incidencia = Incidencia::with([
            'cliente', 'tecnico', 'gestor', 'categoria',
            'subcategoria', 'sede', 'mensajes.usuario', 'adjuntos',
        ])
            ->where('sede_id', $usuario->sede_id)
            ->findOrFail($id);

        // Técnicos de la sede (para asignación desde detalle)
        $tecnicos = User::where('sede_id', $usuario->sede_id)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('gestor.incidencia-detalle', compact('usuario', 'incidencia', 'tecnicos'));
    }

    /**
     * Asignar técnico y prioridad a una incidencia.
     * Usa transacción porque actualiza múltiples campos críticos.
     */
    public function asignar(Request $request, int $id): JsonResponse
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $request->validate([
            'tecnico_id' => 'required|integer|exists:usuarios,id',
            'prioridad'  => 'required|in:alta,media,baja',
        ]);

        // Verificar que la incidencia pertenece a la sede del gestor
        $incidencia = Incidencia::where('sede_id', $usuario->sede_id)
            ->findOrFail($id);

        // Verificar que el técnico pertenece a la misma sede
        $tecnico = User::where('id', $request->input('tecnico_id'))
            ->where('sede_id', $usuario->sede_id)
            ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $incidencia->update([
                'tecnico_id'  => $tecnico->id,
                'gestor_id'   => $usuario->id,
                'prioridad'   => $request->input('prioridad'),
                'estado'      => 'asignada',
                'asignado_en' => now(),
            ]);

            DB::commit();

            return response()->json([
                'exito'   => true,
                'mensaje' => 'Incidencia ' . $incidencia->codigo . ' asignada correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'exito'   => false,
                'mensaje' => 'Error al asignar la incidencia: ' . $e->getMessage(),
            ], 500);
        }
    }
}
