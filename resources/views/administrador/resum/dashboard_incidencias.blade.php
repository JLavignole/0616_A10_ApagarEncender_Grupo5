@extends('layouts.app')

@section('titulo', 'Dashboard Incidencias — Administrador')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Dashboard Incidencias</h2>
            <p class="seccion-subtitulo">Resumen general de incidencias por sede</p>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-morado">
                    <i class="bi bi-clipboard2-pulse-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalIncidencias }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias totales</div> <!-- Incidencias totales en esa sede -->
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalIncidenciasResueltas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias resueltas</div> <!-- Incidencias resueltas en esa sede -->
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-azul">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $totalIncidenciasPendientes }}</div>
                    <div class="tarjeta-kpi-etiqueta">Incidencias pendientes</div> <!-- Incidencias pendientes en esa sede -->
                </div>
            </div>
        </div>

    </div>

    <h3 class="accesos-titulo">Accesos rápidos</h3>

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('administrador.dashboard') }}" class="tarjeta-acceso">
                <i class="bi bi-speedometer2"></i>
                <span class="tarjeta-acceso-texto">Dashboard general</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('administrador.usuarios.index') }}" class="tarjeta-acceso">
                <i class="bi bi-people"></i>
                <span class="tarjeta-acceso-texto">Gestionar usuarios</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('administrador.incidencias.index') }}" class="tarjeta-acceso">
                <i class="bi bi-clipboard2-pulse"></i>
                <span class="tarjeta-acceso-texto">Gestionar incidencias</span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('administrador.sanciones.index') }}" class="tarjeta-acceso">
                <i class="bi bi-shield-exclamation"></i>
                <span class="tarjeta-acceso-texto">Ver sanciones</span>
            </a>
        </div>

    </div>

    <form method="GET" action="{{ route('administrador.dashboard.incidencias') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-select">
            <select name="sede" id="selectSede" class="filtro-select">
                <option value="">Sede</option>
                @foreach ($sedes as $sede)
                    <option value="{{ $sede->id }}" {{ request('sede') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="filtros-select">
            <select name="categoria" id="selectCategoria" class="filtro-select">
                <option value="">Categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        @if(request('buscar') || request('estado') || request('prioridad') || request('sede') || request('categoria') || request('fecha'))
            <a href="{{ route('administrador.dashboard.incidencias') }}" class="btn-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif

    </form>

    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Desglose de incidencias resueltas por técnico y categoría</h3>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Técnico</th>
                        <th>Categoría</th> <!-- Aqui van todas las categorias que hay -->
                        <th>Total</th> <!-- Total de incidencias tiene que ser de resueltas en esa categoria en la nueva tabla -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($desgloseIncidencias as $fila)
                        <tr>
                            <td>{{ $fila->tecnico->nombre ?? '—' }}</td>
                            <td>{{ $fila->categoria->nombre ?? '—' }}</td>
                            <td>{{ $fila->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="td-vacio">
                                <i class="bi bi-inbox"></i> Sin incidencias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $desgloseIncidencias->links() }}
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/dashboard.js') }}"></script>
@endpush
