@extends('layouts.app')

@section('titulo', 'Detalle de Incidencia')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="detalle-topbar">
        <a href="{{ route('cliente.incidencias.index') }}" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Detalle de Incidencia
        </a>

        @if ($incidencia->estado === 'resuelta')
            <form id="form-cerrar-incidencia"
                  method="POST"
                  action="{{ route('cliente.incidencias.cerrar', $incidencia) }}">
                @csrf
                @method('PATCH')
                <button type="button"
                        id="btn-cerrar-incidencia"
                        class="btn btn-success btn-accion btn-cerrar"
                        data-codigo="{{ $incidencia->codigo }}">
                    <i class="bi bi-check2-circle me-1"></i> Marcar como Cerrada
                </button>
            </form>
        @endif
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
            <p class="detalle-seccion">DESCRIPCIÓN</p>
            <div class="detalle-descripcion">
                {!! nl2br(e($incidencia->descripcion)) !!}
            </div>

            {{-- Actividad (Chat) ── --}}
            <p class="detalle-seccion">ACTIVIDAD Y CHAT</p>
            
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

                                    {{-- Imágenes adjuntas en el mensaje --}}
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
                            <p>No hay mensajes todavía. ¡Inicia la conversación!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Formulario de envío (solo si no está cerrada) --}}
                @if($incidencia->estado !== 'cerrada')
                    <div class="chat-input-area">
                        <form id="form-chat" 
                              action="{{ route('cliente.incidencias.mensaje', $incidencia) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            <div class="chat-input-wrapper">
                                <label for="adjunto-chat" class="btn-adjuntar" title="Adjuntar imagen">
                                    <i class="bi bi-image"></i>
                                    <input type="file" id="adjunto-chat" name="imagen" accept="image/*" style="display: none;">
                                </label>
                                
                                <textarea name="cuerpo" id="cuerpo-mensaje" placeholder="Escribe un mensaje..." rows="1"></textarea>
                                
                                <button type="submit" class="btn-enviar-chat" id="btn-enviar">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                            <div id="preview-adjunto" class="preview-adjunto" style="display: none;">
                                <span class="preview-nombre"></span>
                                <button type="button" class="btn-quitar-adjunto"><i class="bi bi-x"></i></button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="chat-cerrado-aviso">
                        <i class="bi bi-lock-fill"></i> Esta incidencia está cerrada. No se pueden enviar más mensajes.
                    </div>
                @endif
            </div>

        </div>

        {{-- ═══ Columna lateral ═══ --}}
        <div class="detalle-lateral">

            {{-- Card: Detalles --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Detalles</p>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Estado</span>
                    <span class="detalle-info-valor">
                        {{ str_replace('_', ' ', ucfirst($incidencia->estado)) }}
                    </span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Prioridad</span>
                    <span class="detalle-info-valor">
                        @if ($incidencia->prioridad)
                            <span class="badge-prioridad badge-prioridad--{{ $incidencia->prioridad }}">
                                {{ ucfirst($incidencia->prioridad) }}
                            </span>
                        @else
                            <span class="text-muted">Sin asignar</span>
                        @endif
                    </span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Categoría</span>
                    <span class="detalle-info-valor">
                        {{ $incidencia->categoria->nombre ?? '—' }}
                        @if ($incidencia->subcategoria)
                            / {{ $incidencia->subcategoria->nombre }}
                        @endif
                    </span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Sede</span>
                    <span class="detalle-info-valor">{{ $incidencia->sede->nombre ?? '—' }}</span>
                </div>

                <div class="detalle-info-fila">
                    <span class="detalle-info-label">Fecha creación</span>
                    <span class="detalle-info-valor">
                        {{ $incidencia->reportado_en?->format('d M, H:i') ?? '—' }}
                    </span>
                </div>

                @if ($incidencia->cerrado_en)
                    <div class="detalle-info-fila">
                        <span class="detalle-info-label">Fecha cierre</span>
                        <span class="detalle-info-valor">
                            {{ $incidencia->cerrado_en->format('d M, H:i') }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Card: Técnico asignado --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Técnico Asignado</p>

                @if ($incidencia->tecnico)
                    <div class="tecnico-info">
                        <div class="tecnico-avatar">
                            {{ strtoupper(substr($incidencia->tecnico->nombre, 0, 1)) }}
                        </div>
                        <div>
                            <div class="tecnico-nombre">{{ $incidencia->tecnico->nombre }}</div>
                            <div class="tecnico-cargo">
                                {{ $incidencia->tecnico->perfil->cargo ?? 'Técnico' }}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted" style="font-size: 13px;">
                        Pendiente de asignación
                    </p>
                @endif
            </div>

            {{-- Card: Adjuntos --}}
            <div class="detalle-card">
                <p class="detalle-card-titulo">Adjuntos</p>

                @forelse ($incidencia->adjuntos as $adj)
                    <a href="{{ asset('storage/' . $adj->ruta) }}"
                       target="_blank"
                       class="adjunto-item">
                        <i class="bi bi-file-earmark adjunto-icono"></i>
                        <div class="adjunto-info">
                            <div class="adjunto-nombre">{{ $adj->nombre_original }}</div>
                            <div class="adjunto-tamano">
                                {{ number_format($adj->tamano / 1024, 0) }} KB
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-muted" style="font-size: 13px;">
                        Sin archivos adjuntos
                    </p>
                @endforelse
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/incidencias.js') }}"></script>
@endpush
