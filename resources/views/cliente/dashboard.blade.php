@extends('layouts.app')

@section('titulo', 'Dashboard — Cliente')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/dashboard.css') }}">
@endpush

@section('contenido')

    {{-- ── Bienvenida ── --}}
    <div class="dash-bienvenida">
        <div class="dash-bienvenida-texto">
            <h2 class="dash-bienvenida-nombre">Hola, {{ $usuario->nombre }}</h2>
            <p class="dash-bienvenida-sub">Tienes <strong>{{ $incidenciasAbiertas }}</strong> {{ $incidenciasAbiertas === 1 ? 'incidencia activa' : 'incidencias activas' }} en este momento.</p>
        </div>
        <a href="{{ route('cliente.incidencias.crear') }}" class="dash-btn-crear">
            <i class="bi bi-plus-lg"></i>
            <span>Nueva incidencia</span>
        </a>
    </div>

    {{-- ── Pipeline de estados ── --}}
    <div class="dash-pipeline">
        <p class="dash-pipeline-titulo">Flujo de mis incidencias</p>
        <div class="dash-pipeline-flujo">
            <div class="dash-pipeline-paso">
                <div class="dash-pipeline-numero pipeline-gris">{{ $sinAsignar }}</div>
                <span class="dash-pipeline-label">Sin asignar</span>
            </div>
            <div class="dash-pipeline-flecha"><i class="bi bi-chevron-right"></i></div>
            <div class="dash-pipeline-paso">
                <div class="dash-pipeline-numero pipeline-azul">{{ $asignadas }}</div>
                <span class="dash-pipeline-label">Asignadas</span>
            </div>
            <div class="dash-pipeline-flecha"><i class="bi bi-chevron-right"></i></div>
            <div class="dash-pipeline-paso">
                <div class="dash-pipeline-numero pipeline-morado">{{ $enProgreso }}</div>
                <span class="dash-pipeline-label">En progreso</span>
            </div>
            <div class="dash-pipeline-flecha"><i class="bi bi-chevron-right"></i></div>
            <div class="dash-pipeline-paso">
                <div class="dash-pipeline-numero pipeline-verde">{{ $resueltas }}</div>
                <span class="dash-pipeline-label">Resueltas</span>
            </div>
            <div class="dash-pipeline-flecha"><i class="bi bi-chevron-right"></i></div>
            <div class="dash-pipeline-paso">
                <div class="dash-pipeline-numero pipeline-oscuro">{{ $cerradas }}</div>
                <span class="dash-pipeline-label">Cerradas</span>
            </div>
        </div>
    </div>

    {{-- ── Grid: resumen + accesos rápidos ── --}}
    <div class="dash-grid">

        {{-- Columna izquierda: tarjetas de incidencias recientes --}}
        <div class="dash-col-principal">
            <div class="dash-bloque-header">
                <h3 class="dash-bloque-titulo">Incidencias activas recientes</h3>
                <a href="{{ route('cliente.incidencias.index') }}" class="dash-bloque-enlace">Ver todas <i class="bi bi-arrow-right"></i></a>
            </div>

            @forelse ($recientes as $inc)
                <a href="{{ route('cliente.incidencias.detalle', $inc) }}" class="dash-incidencia-card">
                    <div class="dash-inc-izq">
                        <span class="dash-inc-dot dash-inc-dot--{{ $inc->estado }}"></span>
                    </div>
                    <div class="dash-inc-cuerpo">
                        <div class="dash-inc-titulo">{{ \Illuminate\Support\Str::limit($inc->titulo, 50) }}</div>
                        <div class="dash-inc-meta">
                            <span class="dash-inc-codigo">{{ $inc->codigo }}</span>
                            <span class="dash-inc-sep">&middot;</span>
                            <span>{{ $inc->categoria->nombre ?? '—' }}</span>
                            <span class="dash-inc-sep">&middot;</span>
                            <span>{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="dash-inc-der">
                        <span class="badge-estado badge-estado--{{ $inc->estado }}">
                            {{ str_replace('_', ' ', ucfirst($inc->estado)) }}
                        </span>
                        @if ($inc->prioridad)
                            <span class="badge-prioridad badge-prioridad--{{ $inc->prioridad }}">
                                {{ ucfirst($inc->prioridad) }}
                            </span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="dash-vacio">
                    <i class="bi bi-inbox"></i>
                    <p>No tienes incidencias activas</p>
                    <a href="{{ route('cliente.incidencias.crear') }}">Crea tu primera incidencia</a>
                </div>
            @endforelse
        </div>

        {{-- Columna derecha: resumen y accesos rápidos --}}
        <div class="dash-col-lateral">

            {{-- Resumen numérico --}}
            <div class="dash-resumen-card">
                <div class="dash-resumen-icono">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
                <div class="dash-resumen-big">{{ $totalMisIncidencias }}</div>
                <div class="dash-resumen-label">Total incidencias</div>
                <div class="dash-resumen-barra">
                    @php
                        $pctAbiertas = $totalMisIncidencias > 0 ? round($incidenciasAbiertas / $totalMisIncidencias * 100) : 0;
                    @endphp
                    <div class="dash-resumen-barra-fill" style="width: {{ $pctAbiertas }}%"></div>
                </div>
                <div class="dash-resumen-leyenda">
                    <span><span class="dash-dot dash-dot--activas"></span>{{ $incidenciasAbiertas }} activas</span>
                    <span><span class="dash-dot dash-dot--cerradas"></span>{{ $resueltas + $cerradas }} cerradas</span>
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="dash-accesos">
                <p class="dash-accesos-titulo">Accesos rápidos</p>
                <a href="{{ route('cliente.incidencias.crear') }}" class="dash-acceso-item">
                    <i class="bi bi-plus-circle"></i>
                    <span>Crear incidencia</span>
                </a>
                <a href="{{ route('cliente.incidencias.index') }}" class="dash-acceso-item">
                    <i class="bi bi-list-check"></i>
                    <span>Mis incidencias</span>
                </a>
                <a href="{{ route('cliente.incidencias.index', ['estado' => 'resuelta']) }}" class="dash-acceso-item">
                    <i class="bi bi-check2-square"></i>
                    <span>Pendientes de cerrar</span>
                </a>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/dashboard.js') }}"></script>
@endpush
