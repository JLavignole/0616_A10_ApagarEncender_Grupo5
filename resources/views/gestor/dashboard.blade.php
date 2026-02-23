@extends('layouts.app')

@section('titulo', 'Dashboard — Gestor')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/gestor/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Panel del Gestor</h2>
            <p class="seccion-subtitulo">Estado actual de las incidencias</p>
        </div>
        <a href="#" class="btn btn-primary btn-accion">
            <i class="bi bi-bar-chart-line me-2"></i>Carga por técnico
        </a>
    </div>

    {{-- ── KPIs ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-rojo">
                    <i class="bi bi-clipboard-x-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasSinAsignar }}</div>
                    <div class="tarjeta-kpi-etiqueta">Sin asignar</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasEnProgreso }}</div>
                    <div class="tarjeta-kpi-etiqueta">En progreso</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-verde">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $tecnicosActivos }}</div>
                    <div class="tarjeta-kpi-etiqueta">Técnicos activos</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Incidencias sin asignar ── --}}
    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Incidencias pendientes de asignación</h3>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Prioridad</th>
                        <th>Sede</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendientes as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td>
                                @if ($inc->prioridad)
                                    <span class="badge-prioridad badge-prioridad--{{ $inc->prioridad }}">
                                        {{ ucfirst($inc->prioridad) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $inc->sede->nombre ?? '—' }}</td>
                            <td>{{ $inc->cliente->nombre ?? '—' }}</td>
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Asignar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="td-vacio">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                No hay incidencias pendientes de asignación
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/gestor/dashboard.js') }}"></script>
@endpush
