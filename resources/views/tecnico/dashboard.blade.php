@extends('layouts.app')

@section('titulo', 'Dashboard — Técnico')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/tecnico/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Panel del Técnico</h2>
            <p class="seccion-subtitulo">Tus incidencias asignadas</p>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-azul">
                    <i class="bi bi-clipboard2-check-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $asignadas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias asignadas</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $enProgreso }}</div>
                    <div class="tarjeta-kpi-etiqueta">En progreso</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-verde">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $resueltasHoy }}</div>
                    <div class="tarjeta-kpi-etiqueta">Resueltas hoy</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Mis incidencias activas ── --}}
    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Mis incidencias activas</h3>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Cliente</th>
                        <th>Sede</th>
                        <th>Desde</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($misIncidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 38) }}</td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $inc->estado }}">
                                    {{ str_replace('_', ' ', ucfirst($inc->estado)) }}
                                </span>
                            </td>
                            <td>
                                @if ($inc->prioridad)
                                    <span class="badge-prioridad badge-prioridad--{{ $inc->prioridad }}">
                                        {{ ucfirst($inc->prioridad) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $inc->cliente->nombre ?? '—' }}</td>
                            <td>{{ $inc->sede->nombre ?? '—' }}</td>
                            <td class="td-fecha">{{ $inc->asignado_en?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="td-vacio">
                                <i class="bi bi-inbox"></i> No tienes incidencias asignadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/tecnico/dashboard.js') }}"></script>
@endpush
