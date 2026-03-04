<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Adjunto;
use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\MensajeIncidencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncidenciasAsignadasController extends Controller
{
    /**
     * Listado de incidencias asignadas al técnico autenticado.
     */
    public function index(Request $request): View
    {
        $query = Incidencia::where('tecnico_id', Auth::id())
            ->with(['cliente', 'sede', 'categoria', 'subcategoria']);

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', '%' . $buscar . '%')
                  ->orWhere('codigo', 'like', '%' . $buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $orden = $request->input('orden', 'fecha_desc');
        if ($orden === 'fecha_asc') {
            $query->oldest('reportado_en');
        } else {
            $query->latest('reportado_en');
        }

        $incidencias = $query->paginate(7)->withQueryString();
        $categorias  = Categoria::orderBy('nombre')->get();

        return view('tecnico.incidencias.index', compact('incidencias', 'categorias'));
    }

    /**
     * Detalle de una incidencia asignada al técnico.
     */
    public function show(Incidencia $incidencia): View
    {
        if ($incidencia->tecnico_id !== Auth::id()) {
            abort(403);
        }

        $incidencia->load([
            'cliente',
            'sede',
            'categoria',
            'subcategoria',
            'adjuntos',
            'mensajes.usuario',
            'mensajes.adjuntos',
        ]);

        return view('tecnico.incidencias.detalle', compact('incidencia'));
    }

    /**
     * Cambiar estado: asignada → en_progreso.
     */
    public function comenzar(Incidencia $incidencia): RedirectResponse
    {
        if ($incidencia->tecnico_id !== Auth::id()) {
            abort(403);
        }

        if ($incidencia->estado !== 'asignada') {
            return back()->with('error', 'La incidencia no está en estado "Asignada".');
        }

        $incidencia->update(['estado' => 'en_progreso']);

        return back()->with('exito', 'Has comenzado a trabajar en la incidencia.');
    }

    /**
     * Cambiar estado: en_progreso → resuelta (guarda fecha de resolución).
     */
    public function resolver(Incidencia $incidencia): RedirectResponse
    {
        if ($incidencia->tecnico_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($incidencia->estado, ['en_progreso', 'reabierta'])) {
            return back()->with('error', 'La incidencia debe estar "En progreso" o "Reabierta" para resolverla.');
        }

        $incidencia->update([
            'estado'      => 'resuelta',
            'resuelto_en' => now(),
        ]);

        return back()->with('exito', 'Incidencia marcada como resuelta.');
    }

    /**
     * Enviar mensaje de chat dentro de la incidencia.
     * Usa transacción porque puede crear mensaje + adjunto (2 tablas).
     */
    public function sendMessage(Request $request, Incidencia $incidencia): RedirectResponse
    {
        if ($incidencia->tecnico_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cuerpo' => ['required_without:imagen', 'nullable', 'string'],
            'imagen' => ['nullable', 'image', 'max:5120'],
        ], [
            'cuerpo.required_without' => 'Debes escribir un mensaje o adjuntar una imagen.',
            'imagen.image'            => 'El archivo debe ser una imagen válida.',
            'imagen.max'              => 'La imagen no puede superar los 5 MB.',
        ]);

        DB::beginTransaction();

        try {
            $mensaje = MensajeIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'usuario_id'    => Auth::id(),
                'cuerpo'        => $validated['cuerpo'] ?? '',
            ]);

            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $ruta    = $archivo->store('adjuntos/mensajes', 'public');

                Adjunto::create([
                    'disco'           => 'public',
                    'ruta'            => $ruta,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'tipo_mime'       => $archivo->getMimeType(),
                    'tamano'          => $archivo->getSize(),
                    'subido_por'      => Auth::id(),
                    'mensaje_id'      => $mensaje->id,
                ]);
            }

            DB::commit();

            return back()->with('exito', 'Mensaje enviado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al enviar el mensaje. Inténtalo de nuevo.');
        }
    }
}

