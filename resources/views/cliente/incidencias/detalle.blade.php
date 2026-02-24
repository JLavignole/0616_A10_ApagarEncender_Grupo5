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

            {{-- Actividad (mensajes) --}}
            <p class="detalle-seccion">ACTIVIDAD</p>
            <div class="actividad-lista">
                @forelse ($incidencia->mensajes as $msg)
                    @if (!$msg->eliminado)
                        <div class="actividad-item">
                            <div class="actividad-avatar">
                                {{ strtoupper(substr($msg->usuario->nombre ?? '?', 0, 1)) }}
                            </div>
                            <div class="actividad-contenido">
                                <div class="actividad-cabecera">
                                    <div>
                                        <span class="actividad-nombre">{{ $msg->usuario->nombre ?? 'Usuario' }}</span>
                                        @if ($msg->usuario && $msg->usuario->rol)
                                            <span class="actividad-rol">({{ ucfirst($msg->usuario->rol->nombre) }})</span>
                                        @endif
                                    </div>
                                    <span class="actividad-fecha">
                                        {{ $msg->created_at->format('d/m/Y, H:i') }}
                                    </span>
                                </div>
                                <p class="actividad-texto">{{ $msg->cuerpo }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-muted" style="font-size: 13px;">
                        <i class="bi bi-chat-dots"></i> No hay mensajes en esta incidencia todavía.
                    </p>
                @endforelse
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
