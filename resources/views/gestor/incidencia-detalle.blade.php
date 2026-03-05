@extends('layouts.app')

@section('titulo', 'Detalle — ' . $incidencia->codigo)

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/gestor/incidencia-detalle.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="detalle-cabecera">
        <div>
            <a href="{{ route('gestor.incidencias') }}" class="detalle-volver">
                <i class="bi bi-arrow-left me-1"></i>Volver a incidencias
            </a>
            <h2 class="seccion-titulo">{{ $incidencia->codigo }}</h2>
            <p class="seccion-subtitulo">{{ $incidencia->titulo }}</p>
        </div>
        <div class="detalle-cabecera-acciones">
            <span class="badge-estado badge-estado--{{ $incidencia->estado }}">
                {{ str_replace('_', ' ', ucfirst($incidencia->estado)) }}
            </span>
            @if ($incidencia->estado !== 'cerrada')
                <button type="button"
                        class="btn btn-primary btn-accion btn-abrir-asignar"
                        data-id="{{ $incidencia->id }}"
                        data-codigo="{{ $incidencia->codigo }}"
                        data-url="{{ route('gestor.incidencias.asignar', $incidencia->id) }}"
                        data-prioridad="{{ $incidencia->prioridad ?? '' }}"
                        data-tecnico-id="{{ $incidencia->tecnico_id ?? '' }}">
                    <i class="bi bi-person-plus me-1"></i>{{ $incidencia->estado === 'sin_asignar' ? 'Asignar' : 'Reasignar' }}
                </button>
            @endif
        </div>
    </div>

    <div class="detalle-grid">

        {{-- ── Info principal ── --}}
        <div class="detalle-card detalle-card--principal">
            <h3 class="detalle-card-titulo">Información de la incidencia</h3>

            <div class="detalle-campo">
                <span class="detalle-etiqueta">Descripción</span>
                <p class="detalle-valor detalle-descripcion">{{ $incidencia->descripcion }}</p>
            </div>

            @if ($incidencia->comentario_cliente)
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Comentario del cliente</span>
                    <p class="detalle-valor">{{ $incidencia->comentario_cliente }}</p>
                </div>
            @endif

            <div class="detalle-fila">
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Categoría</span>
                    <span class="detalle-valor">{{ $incidencia->categoria->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Subcategoría</span>
                    <span class="detalle-valor">{{ $incidencia->subcategoria->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Prioridad</span>
                    @if ($incidencia->prioridad)
                        <span class="badge-prioridad badge-prioridad--{{ $incidencia->prioridad }}">
                            {{ ucfirst($incidencia->prioridad) }}
                        </span>
                    @else
                        <span class="detalle-valor text-muted">Sin asignar</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Lateral: personas y fechas ── --}}
        <div class="detalle-lateral">

            <div class="detalle-card">
                <h3 class="detalle-card-titulo">Personas</h3>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Cliente</span>
                    <span class="detalle-valor">{{ $incidencia->cliente->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Gestor</span>
                    <span class="detalle-valor">{{ $incidencia->gestor->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Técnico</span>
                    <span class="detalle-valor">{{ $incidencia->tecnico->nombre ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Sede</span>
                    <span class="detalle-valor">{{ $incidencia->sede->nombre ?? '—' }}</span>
                </div>
            </div>

            <div class="detalle-card">
                <h3 class="detalle-card-titulo">Fechas</h3>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Reportado</span>
                    <span class="detalle-valor">{{ $incidencia->reportado_en?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Asignado</span>
                    <span class="detalle-valor">{{ $incidencia->asignado_en?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Resuelto</span>
                    <span class="detalle-valor">{{ $incidencia->resuelto_en?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="detalle-campo">
                    <span class="detalle-etiqueta">Cerrado</span>
                    <span class="detalle-valor">{{ $incidencia->cerrado_en?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
            </div>

        </div>

    </div>

    {{-- ── Conversación cliente ↔ técnico ── --}}
    <div class="detalle-card mt-4">
        <div class="conversacion-cabecera">
            <h3 class="detalle-card-titulo detalle-card-titulo--plano">
                <i class="bi bi-chat-left-text me-2"></i>Conversación
                <span class="conversacion-contador">{{ $incidencia->mensajes->count() }}</span>
            </h3>
            @if ($incidencia->mensajes->count() > 0)
                <span class="conversacion-participantes">
                    <i class="bi bi-people-fill me-1"></i>
                    {{ $incidencia->cliente->nombre ?? 'Cliente' }}
                    @if ($incidencia->tecnico)
                        &nbsp;↔&nbsp; {{ $incidencia->tecnico->nombre }}
                    @endif
                </span>
            @endif
        </div>

        <div class="chat-contenedor-gestor">
            <div class="chat-lista-gestor" id="chat-mensajes-gestor">
                @forelse ($incidencia->mensajes as $msg)
                    @if (!$msg->eliminado)
                        @php
                            $esCliente  = $incidencia->cliente_id === $msg->usuario_id;
                            $esTecnico  = $incidencia->tecnico_id === $msg->usuario_id;
                            $rolClase   = $esCliente ? 'msg-cliente' : ($esTecnico ? 'msg-tecnico' : 'msg-otro');
                            $rolTexto   = $esCliente ? 'Cliente' : ($esTecnico ? 'Técnico' : ($msg->usuario->rol->nombre ?? 'Usuario'));
                        @endphp
                        <div class="chat-msg {{ $rolClase }}">
                            <div class="chat-msg-avatar {{ $rolClase }}">
                                {{ strtoupper(substr($msg->usuario->nombre ?? '?', 0, 1)) }}
                            </div>
                            <div class="chat-msg-burbuja">
                                <div class="chat-msg-header">
                                    <div>
                                        <span class="chat-msg-nombre">{{ $msg->usuario->nombre ?? 'Usuario' }}</span>
                                        <span class="chat-msg-rol chat-msg-rol--{{ $rolClase }}">{{ ucfirst($rolTexto) }}</span>
                                    </div>
                                    <span class="chat-msg-fecha">{{ $msg->created_at->format('d/m/Y, H:i') }}</span>
                                </div>

                                @if($msg->cuerpo)
                                    <p class="chat-msg-texto">{{ $msg->cuerpo }}</p>
                                @endif

                                {{-- Adjuntos del mensaje --}}
                                @if($msg->adjuntos->count() > 0)
                                    <div class="chat-msg-adjuntos">
                                        @foreach($msg->adjuntos as $adj)
                                            @if(str_contains($adj->tipo_mime ?? '', 'image'))
                                                <a href="{{ asset('storage/' . $adj->ruta) }}" target="_blank" class="chat-adjunto-img-link">
                                                    <img src="{{ asset('storage/' . $adj->ruta) }}" alt="Adjunto" class="chat-adjunto-img">
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $adj->ruta) }}" target="_blank" class="chat-adjunto-archivo">
                                                    <i class="bi bi-file-earmark"></i> {{ $adj->nombre_original ?? 'Archivo' }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="chat-vacio-gestor">
                        <i class="bi bi-chat-dots"></i>
                        <p>No hay mensajes en esta incidencia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Adjuntos ── --}}
    @if ($incidencia->adjuntos->count() > 0)
        <div class="detalle-card mt-4">
            <h3 class="detalle-card-titulo">Adjuntos ({{ $incidencia->adjuntos->count() }})</h3>
            <div class="lista-adjuntos">
                @foreach ($incidencia->adjuntos as $adj)
                    <a href="{{ asset('storage/' . $adj->ruta_archivo) }}" target="_blank" class="adjunto-item">
                        <i class="bi bi-paperclip"></i>
                        <span>{{ $adj->nombre_original ?? $adj->ruta_archivo }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Modal de asignación ── --}}
    <div class="modal-overlay" id="modalAsignar" hidden>
        <div class="modal-caja">
            <div class="modal-cabecera">
                <h4 class="modal-titulo">Asignar incidencia <span id="modalCodigoInc"></span></h4>
                <button type="button" class="modal-cerrar" id="btnCerrarModal">&times;</button>
            </div>
            <div class="modal-cuerpo">
                <div class="campo-grupo">
                    <label for="selectPrioridad" class="campo-label">Prioridad</label>
                    <select id="selectPrioridad" class="campo-select">
                        <option value="">— Seleccionar —</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>
                <div class="campo-grupo">
                    <label for="selectTecnico" class="campo-label">Técnico</label>
                    <select id="selectTecnico" class="campo-select">
                        <option value="">— Seleccionar técnico —</option>
                        @foreach ($tecnicos as $tec)
                            <option value="{{ $tec->id }}">{{ $tec->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-pie">
                <button type="button" class="btn btn-secondary" id="btnCancelarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarAsignar">
                    <i class="bi bi-check-lg me-1"></i>Asignar
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/gestor/incidencia-detalle.js') }}"></script>
@endpush
