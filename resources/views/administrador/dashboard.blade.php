@extends('layouts.app')

@section('titulo', 'Dashboard — Administrador')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Panel de Administración</h2>
            <p class="seccion-subtitulo">Resumen general del sistema</p>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-azul">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalUsuarios }}</div>
                    <div class="tarjeta-kpi-etiqueta">Usuarios registrados</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-morado">
                    <i class="bi bi-clipboard2-pulse-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalIncidencias }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias totales</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasAbiertas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias abiertas</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Accesos rápidos ── --}}
    <h3 class="accesos-titulo">Accesos rápidos</h3>

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('administrador.dashboard.incidencias') }}" class="tarjeta-acceso">
                <i class="bi bi-people"></i>
                <span class="tarjeta-acceso-texto">Dashboard Incidencias</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="#" class="tarjeta-acceso">
                <i class="bi bi-people"></i>
                <span class="tarjeta-acceso-texto">Gestionar usuarios</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="#" class="tarjeta-acceso">
                <i class="bi bi-tags"></i>
                <span class="tarjeta-acceso-texto">Gestionar categorías</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="#" class="tarjeta-acceso">
                <i class="bi bi-building"></i>
                <span class="tarjeta-acceso-texto">Gestionar sedes</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="#" class="tarjeta-acceso">
                <i class="bi bi-shield-exclamation"></i>
                <span class="tarjeta-acceso-texto">Ver sanciones</span>
            </a>
        </div>

    </div>

    {{-- ── Filtros de incidencias ── --}}
    <form method="GET" action="{{ route('administrador.dashboard') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por código..." autocomplete="off">
        </div>

        <div class="filtros-select">
            <select name="estado" id="selectEstado" class="filtro-select">
                <option value="">Estado</option>
                <option value="sin_asignar" {{ request('estado') === 'sin_asignar' ? 'selected' : '' }}>Sin asignar</option>
                <option value="asignada" {{ request('estado') === 'asignada' ? 'selected' : '' }}>Asignada</option>
                <option value="en_progreso" {{ request('estado') === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                <option value="resuelta" {{ request('estado') === 'resuelta' ? 'selected' : '' }}>Resuelta</option>
                <option value="cerrada" {{ request('estado') === 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                <option value="reabierta" {{ request('estado') === 'reabierta' ? 'selected' : '' }}>Reabierta</option>
            </select>
        </div>

        <div class="filtros-select">
            <select name="prioridad" id="selectPrioridad" class="filtro-select">
                <option value="">Prioridad</option>
                <option value="alta" {{ request('prioridad') === 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ request('prioridad') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="baja" {{ request('prioridad') === 'baja' ? 'selected' : '' }}>Baja</option>
            </select>
        </div>

        <div class="filtros-select">
            <select name="sede" id="selectSede" class="filtro-select">
                <option value="">Sede</option>
                @foreach ($sedes as $sede)
                    <option value="{{ $sede->id }}" {{ request('sede') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="filtros-fecha">
            <input type="date" name="fecha" id="inputFecha" value="{{ request('fecha') }}" class="filtro-fecha">
        </div>

        @if(request('buscar') || request('estado') || request('prioridad') || request('sede') || request('fecha'))
            <a href="{{ route('administrador.dashboard') }}" class="btn-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif

    </form>

    {{-- ── Tabla últimas incidencias ── --}}
    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Últimas incidencias</h3>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Sede</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimasIncidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 42) }}</td>
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
                            <td>{{ $inc->sede->nombre ?? '—' }}</td>
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td-vacio">
                                <i class="bi bi-inbox"></i> Sin incidencias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $ultimasIncidencias->links() }}
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/dashboard.js') }}"></script>
@endpush
