@extends('layouts.app')

@section('titulo', 'Detalle de Incidencia — Técnico')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/tecnico/incidencias/detalle.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="detalle-topbar">
        <a href="{{ route('tecnico.incidencias.index') }}" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>

        <div class="d-flex gap-2">
            {{-- Botón Comenzar (Solo si está asignada) --}}
            @if($incidencia->estado === 'asignada')
                <form id="form-comenzar" action="{{ route('tecnico.comenzar', $incidencia) }}" method="POST">
                    @csrf
                    <button type="button"
                            id="btn-comenzar"
                            class="btn btn-primary btn-accion"
                            data-codigo="{{ $incidencia->codigo }}">
                        <i class="bi bi-play-fill"></i> Comenzar Trabajo
                    </button>
                </form>
            @endif

            {{-- Botón Resolver (Solo si está en progreso o reabierta) --}}
            @if(in_array($incidencia->estado, ['en_progreso', 'reabierta']))
                <form id="form-resolver" action="{{ route('tecnico.resolver', $incidencia) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button"
                            id="btn-resolver"
                            class="btn btn-success btn-accion"
                            data-codigo="{{ $incidencia->codigo }}">
                        <i class="bi bi-check-circle"></i> Resolver Incidencia
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- ── Layout de dos columnas ── --}}
    <div class="detalle-grid">

        {{-- ═══ Columna principal ═══ --}}
        <div class="detalle-principal">

            {{-- Código y estado --}}
            <div class="detalle-cabecera">
                <span class="detalle-codigo">#{{ $incidencia->codigo }}</span>
                <span class="badge-estado badge-estado--{{ $incidencia->estado }}">
                    {{ str_replace('_', ' ', ucfirst($incidencia->estado)) }}
                </span>
            </div>

            {{-- Título --}}
            <h2 class="detalle-titulo">{{ $incidencia->titulo }}</h2>

            {{-- Descripción --}}
            <p class="detalle-seccion">DESCRIPCIÓN DEL PROBLEMA</p>
            <div class="detalle-descripcion">
                {!! nl2br(e($incidencia->descripcion)) !!}
            </div>

            {{-- Actividad (Chat) --}}
            <p class="detalle-seccion">COMUNICACIÓN CON EL CLIENTE</p>
            
            <div class="chat-contenedor">
                <div class="actividad-lista" id="chat-mensajes">
                    @forelse ($incidencia->mensajes as $msg)
                        @if (!$msg->eliminado)
                            <div class="actividad-item {{ $msg->usuario_id === auth()->id() ? 'mensaje-propio' : '' }}">
                                <div class="actividad-avatar">
                                    {{ strtoupper(substr($msg->usuario->nombre ?? '?', 0, 1)) }}
                                </div>
                                <div class="actividad-contenido">
                                    <div class="actividad-cabecera">
                                        <div>
                                            <span class="actividad-nombre">{{ $msg->usuario_id === auth()->id() ? 'Tú' : ($msg->usuario->nombre ?? 'Usuario') }}</span>
                                            @if ($msg->usuario && $msg->usuario->rol && $msg->usuario_id !== auth()->id())
                                                <span class="actividad-rol">({{ ucfirst($msg->usuario->rol->nombre) }})</span>
                                            @endif
                                        </div>
                                        <span class="actividad-fecha">
                                            {{ $msg->created_at->format('d/m/Y, H:i') }}
                                        </span>
                                    </div>
                                    
                                    @if($msg->cuerpo)
                                        <p class="actividad-texto">{{ $msg->cuerpo }}</p>
                                    @endif

                                    @if($msg->adjuntos->count() > 0)
                                        <div class="mensaje-adjuntos">
                                            @foreach($msg->adjuntos as $adj)
                                                @if(str_contains($adj->tipo_mime, 'image'))
                                                    <a href="{{ asset('storage/' . $adj->ruta) }}" target="_blank" class="mensaje-imagen-link">
                                                        <img src="{{ asset('storage/' . $adj->ruta) }}" alt="Adjunto" class="mensaje-imagen">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $adj->ruta) }}" target="_blank" class="mensaje-archivo">
                                                        <i class="bi bi-file-earmark"></i> {{ $adj->nombre_original }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="chat-vacio">
                            <i class="bi bi-chat-dots"></i>
                            <p>No hay mensajes todavía.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Formulario de envío (solo si no está cerrada o resuelta) --}}
                @if(!in_array($incidencia->estado, ['cerrada']))
                    <div class="chat-input-area">
                        <form id="form-chat" 
                              action="{{ route('tecnico.incidencias.mensaje', $incidencia) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            <div class="chat-input-wrapper">
                                <label for="adjunto-chat" class="btn-adjuntar" title="Adjuntar imagen">
                                    <i class="bi bi-image"></i>
                                    <input type="file" id="adjunto-chat" name="imagen" accept="image/*" class="adjunto-chat-input">
                                </label>
                                
                                <textarea name="cuerpo" id="cuerpo-mensaje" placeholder="Escribe un mensaje al cliente..." rows="1"></textarea>
                                
                                <button type="submit" class="btn-enviar-chat" id="btn-enviar">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="chat-cerrado-aviso">
                        <i class="bi bi-lock-fill"></i> Incidencia finalizada. Chat en modo lectura.
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══ Columna lateral ═══ --}}
        <div class="detalle-lateral">

            {{-- Card: Datos del Cliente --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Cliente y Ubicación</p>
                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Reportado por</span>
                    <span class="detalle-info-valor fw-bold">{{ $incidencia->cliente->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Sede</span>
                    <span class="detalle-info-valor">{{ $incidencia->sede->nombre ?? '—' }}</span>
                </div>
            </div>

            {{-- Card: Detalles Técnicos --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Detalles Técnicos</p>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Prioridad</span>
                    <span class="detalle-info-valor">
                        <span class="badge-prioridad badge-prioridad--{{ $incidencia->prioridad }}">
                            {{ ucfirst($incidencia->prioridad ?? 'Sin asignar') }}
                        </span>
                    </span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Categoría</span>
                    <span class="detalle-info-valor">
                        {{ $incidencia->categoria->nombre ?? '—' }}
                    </span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Creada</span>
                    <span class="detalle-info-valor">
                        {{ $incidencia->reportado_en?->format('d/m/Y H:i') ?? $incidencia->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                @if ($incidencia->resuelto_en)
                    <div class="detalle-info-fila">
                        <span class="detalle-info-label">Resuelta</span>
                        <span class="detalle-info-valor text-success">
                            {{ $incidencia->resuelto_en->format('d/m/Y H:i') }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Card: Adjuntos Iniciales --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Archivos Adjuntos</p>
                @forelse ($incidencia->adjuntos as $adj)
                    <a href="{{ asset('storage/' . $adj->ruta) }}" target="_blank" class="adjunto-item">
                        <i class="bi bi-file-earmark adjunto-icono"></i>
                        <div class="adjunto-info">
                            <div class="adjunto-nombre">{{ $adj->nombre_original }}</div>
                            <div class="adjunto-tamano">{{ number_format($adj->tamano / 1024, 0) }} KB</div>
                        </div>
                    </a>
                @empty
                    <p class="text-muted small">Sin adjuntos iniciales</p>
                @endforelse
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <script src="{{ asset('js/tecnico/incidencias/detalle.js') }}"></script>
@endpush