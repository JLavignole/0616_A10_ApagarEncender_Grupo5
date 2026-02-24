@extends('layouts.app')

@section('titulo', 'Dashboard — Cliente')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Mis incidencias</h2>
            <p class="seccion-subtitulo">Seguimiento de todas tus solicitudes</p>
        </div>
        <a href="#" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-circle me-2"></i>Crear incidencia
        </a>
    </div>

    {{-- ── KPIs ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-azul">
                    <i class="bi bi-clipboard2-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalMisIncidencias }}</div>
                    <div class="tarjeta-kpi-etiqueta">Total incidencias</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasAbiertas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Abiertas / en curso</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-verde">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasCerradas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Cerradas / resueltas</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Lista incidencias recientes ── --}}
    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Incidencias recientes</h3>
            <a href="#" class="tabla-card-enlace">Ver todas</a>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Técnico</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($misIncidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
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
                            <td>{{ $inc->tecnico->nombre ?? '—' }}</td>
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="td-vacio">
                                <i class="bi bi-inbox"></i> No has creado ninguna incidencia todavía
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/dashboard.js') }}"></script>
@endpush
