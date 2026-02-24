<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Adjunto;
use App\Models\MensajeIncidencia;
use App\Models\Categoria;
use App\Models\Incidencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncidenciaController extends Controller
{
    /**
     * Listado filtrable de incidencias del cliente.
     * Oculta cerradas por defecto (5.1).
     */
    public function index(Request $request): View
    {
        $usuario = Auth::user();

        $query = Incidencia::with(['categoria', 'subcategoria', 'tecnico', 'sede'])
            ->where('cliente_id', $usuario->id);

        // Filtro por búsqueda (título o código)
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        // Filtro por estado (oculta cerradas por defecto)
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        } else {
            $query->where('estado', '!=', 'cerrada');

            // Boton para ocultar resueltas
            if ($request->boolean('ocultar_resueltas')) {
                $query->where('estado', '!=', 'resuelta');
            }
        }

        // Filtro por prioridad
        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->input('prioridad'));
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $orden = strtolower($request->input('orden', 'desc'));
        if (!in_array($orden, ['asc', 'desc'], true)) {
            $orden = 'desc';
        }

        $incidencias = $query->orderBy('reportado_en', $orden)
            ->paginate(10)
            ->withQueryString();
        $categorias  = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('cliente.incidencias.index', compact('incidencias', 'categorias'));
    }

    /**
     * Formulario para crear una nueva incidencia.
     */
    public function create(): View
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('cliente.incidencias.crear', compact('categorias'));
    }

    /**
     * Guardar nueva incidencia con código único y adjunto opcional.
     * Usa transacción porque inserta en incidencias + adjuntos (5.4).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'          => ['required', 'string', 'max:255'],
            'descripcion'     => ['required', 'string'],
            'categoria_id'    => ['required', 'exists:categorias,id'],
            'subcategoria_id' => ['required', 'exists:subcategorias,id'],
            'imagen'          => ['nullable', 'image', 'max:3072'], // Máximo 3 MB
        ], [
            'titulo.required'          => 'El título es obligatorio.',
            'titulo.max'               => 'El título no puede superar los 255 caracteres.',
            'descripcion.required'     => 'La descripción es obligatoria.',
            'categoria_id.required'    => 'Selecciona una categoría.',
            'categoria_id.exists'      => 'La categoría seleccionada no es válida.',
            'subcategoria_id.required' => 'Selecciona una subcategoría.',
            'subcategoria_id.exists'   => 'La subcategoría seleccionada no es válida.',
            'imagen.image'             => 'El archivo debe ser una imagen válida.',
            'imagen.max'               => 'La imagen no puede superar los 3 MB.',
        ]);

        $usuario = Auth::user();

        DB::beginTransaction();

        try {
            // Generar código único (5.2)
            $codigo = $this->generarCodigo($usuario);

            $incidencia = Incidencia::create([
                'codigo'          => $codigo,
                'sede_id'         => $usuario->sede_id,
                'cliente_id'      => $usuario->id,
                'categoria_id'    => $validated['categoria_id'],
                'subcategoria_id' => $validated['subcategoria_id'],
                'titulo'          => $validated['titulo'],
                'descripcion'     => $validated['descripcion'],
                'estado'          => 'sin_asignar',
                'reportado_en'    => now(),
            ]);

            // Guardar imagen adjunta si se proporcionó (5.4)
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $ruta    = $archivo->store('adjuntos/incidencias', 'public');

                Adjunto::create([
                    'disco'           => 'public',
                    'ruta'            => $ruta,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'tipo_mime'       => $archivo->getMimeType(),
                    'tamano'          => $archivo->getSize(),
                    'subido_por'      => $usuario->id,
                    'incidencia_id'   => $incidencia->id,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('cliente.incidencias.detalle', $incidencia)
                ->with('exito', 'Incidencia creada correctamente con código ' . $codigo);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al crear la incidencia. Inténtalo de nuevo.');
        }
    }

    /**
     * Detalle de una incidencia del cliente.
     */
    public function show(Incidencia $incidencia): View
    {
        $usuario = Auth::user();

        if ($incidencia->cliente_id !== $usuario->id) {
            abort(403);
        }

        $incidencia->load([
            'categoria',
            'subcategoria',
            'tecnico',
            'sede',
            'mensajes.usuario',
            'adjuntos',
        ]);

        return view('cliente.incidencias.detalle', compact('incidencia'));
    }

    /**
     * Cerrar incidencia — solo si su estado es "resuelta" (5.5).
     */
    public function close(Incidencia $incidencia): RedirectResponse
    {
        $usuario = Auth::user();

        if ($incidencia->cliente_id !== $usuario->id) {
            abort(403);
        }

        if ($incidencia->estado !== 'resuelta') {
            return back()->with('error', 'Solo se pueden cerrar incidencias con estado "Resuelta".');
        }

        $incidencia->update([
            'estado'     => 'cerrada',
            'cerrado_en' => now(),
        ]);

        return back()->with('exito', 'Incidencia cerrada correctamente.');
    }

    /**
     * Enviar un mensaje de chat dentro de la incidencia.
     * Soporta mensaje de texto e imagen adjunta.
     */
    public function sendMessage(Request $request, Incidencia $incidencia): RedirectResponse
    {
        $usuario = Auth::user();

        // Verificar que la incidencia pertenece al cliente
        if ($incidencia->cliente_id !== $usuario->id) {
            abort(403);
        }

        $validated = $request->validate([
            'cuerpo' => ['required_without:imagen', 'nullable', 'string'],
            'imagen' => ['nullable', 'image', 'max:5120'], // Máximo 5MB
        ], [
            'cuerpo.required_without' => 'Debes escribir un mensaje o adjuntar una imagen.',
            'imagen.image'            => 'El archivo debe ser una imagen válida.',
            'imagen.max'              => 'La imagen no puede superar los 5 MB.',
        ]);

        DB::beginTransaction();

        try {
            // Crear el mensaje
            $mensaje = MensajeIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'usuario_id'    => $usuario->id,
                'cuerpo'        => $validated['cuerpo'] ?? '',
            ]);

            // Guardar imagen si existe
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $ruta    = $archivo->store('adjuntos/mensajes', 'public');

                Adjunto::create([
                    'disco'           => 'public',
                    'ruta'            => $ruta,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'tipo_mime'       => $archivo->getMimeType(),
                    'tamano'          => $archivo->getSize(),
                    'subido_por'      => $usuario->id,
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

    /**
     * AJAX: Devuelve las subcategorías activas de una categoría (5.3).
     */
    public function subcategorias(Categoria $categoria): JsonResponse
    {
        $subcategorias = $categoria->subcategorias()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($subcategorias);
    }

    /**
     * Genera código único para la incidencia (5.2).
     * Formato: {SEDE}-{AÑO}-{SECUENCIAL 6 dígitos}
     * Ejemplo: BCN-2026-000001
     */
    private function generarCodigo($usuario): string
    {
        $codigoSede = $usuario->sede->codigo ?? 'GEN';
        $anio       = now()->year;
        $prefijo    = $codigoSede . '-' . $anio . '-';

        $ultimaIncidencia = Incidencia::where('codigo', 'like', $prefijo . '%')
            ->orderByDesc('codigo')
            ->first();

        if ($ultimaIncidencia) {
            $ultimoNumero = (int) substr($ultimaIncidencia->codigo, strlen($prefijo));
            $nuevoNumero  = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $prefijo . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
    }
}
