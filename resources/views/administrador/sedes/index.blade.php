@extends('layouts.app')

@section('titulo', 'Gestión de Sedes')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/sedes/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Sedes</h2>
            <p class="seccion-subtitulo">{{ $sedes->total() }} sedes en total</p>
        </div>
        <a href="{{ route('administrador.sedes.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-lg me-1"></i> Nueva sede
        </a>
    </div>

    <form method="GET" action="{{ route('administrador.sedes.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o código..." autocomplete="off">
        </div>

        <div class="filtros-estado">
            <button type="button"
                    id="btnEstadoTodas"
                    class="btn-filtro-estado {{ $estado === 'todas' ? 'activo' : '' }}">Todas</button>
            <button type="button"
                    id="btnEstadoActivas"
                    class="btn-filtro-estado {{ $estado === 'activas' ? 'activo' : '' }}">Activas</button>
            <button type="button"
                    id="btnEstadoInactivas"
                    class="btn-filtro-estado {{ $estado === 'inactivas' ? 'activo' : '' }}">Inactivas</button>
            <input type="hidden" name="estado" id="inputEstado" value="{{ $estado }}">
        </div>

        @if(request('buscar') || (request('estado') && request('estado') !== 'todas'))
            <a href="{{ route('administrador.sedes.index') }}" class="btn-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif

    </form>

    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Zona horaria</th>
                        <th>Usuarios</th>
                        <th>Estado</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sedes as $sede)
                        <tr class="{{ $sede->activo ? '' : 'fila-inactiva' }}">
                            <td class="td-codigo">{{ $sede->codigo }}</td>
                            <td class="fw-semibold">{{ $sede->nombre }}</td>
                            <td class="td-secundario">{{ $sede->zona_horaria ?? '—' }}</td>
                            <td class="td-secundario">{{ $sede->usuarios()->count() }}</td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $sede->activo ? 'activa' : 'inactiva' }}">
                                    {{ $sede->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="td-acciones">

                                <a href="{{ route('administrador.sedes.editar', $sede) }}"
                                   class="btn-icono btn-icono--editar"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if ($sede->activo)
                                    <form method="POST"
                                          action="{{ route('administrador.sedes.desactivar', $sede) }}"
                                          class="form-toggle"
                                          id="form-desactivar-{{ $sede->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--desactivar"
                                                title="Desactivar sede"
                                                onclick="confirmarDesactivar('{{ $sede->nombre }}', 'form-desactivar-{{ $sede->id }}')">  
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('administrador.sedes.activar', $sede) }}"
                                          class="form-toggle"
                                          id="form-activar-{{ $sede->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--activar"
                                                title="Activar sede"
                                                onclick="confirmarActivar('{{ $sede->nombre }}', 'form-activar-{{ $sede->id }}')">
                                            <i class="bi bi-toggle-off"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron sedes con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($sedes->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $sedes->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/sedes/index.js') }}"></script>
@endpush
