@extends('layouts.app')

@section('titulo', 'Gestión de Categorías')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/categorias/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Categorías</h2>
            <p class="seccion-subtitulo">{{ $categorias->total() }} categorías en total</p>
        </div>
        <a href="{{ route('administrador.categorias.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-lg me-1"></i> Nueva categoría
        </a>
    </div>

    <form method="GET" action="{{ route('administrador.categorias.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." autocomplete="off">
        </div>

        <div class="filtros-estado">
            <button type="button" id="btnEstadoTodas"
                    class="btn-filtro-estado {{ $estado === 'todas' ? 'activo' : '' }}">Todas</button>
            <button type="button" id="btnEstadoActivas"
                    class="btn-filtro-estado {{ $estado === 'activas' ? 'activo' : '' }}">Activas</button>
            <button type="button" id="btnEstadoInactivas"
                    class="btn-filtro-estado {{ $estado === 'inactivas' ? 'activo' : '' }}">Inactivas</button>
            <input type="hidden" name="estado" id="inputEstado" value="{{ $estado }}">
        </div>

        @if(request('buscar') || (request('estado') && request('estado') !== 'todas'))
            <a href="{{ route('administrador.categorias.index') }}" class="btn-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif

    </form>

    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Subcategorías</th>
                        <th>Estado</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $categoria)
                        <tr class="{{ $categoria->activo ? '' : 'fila-inactiva' }}">
                            <td class="fw-semibold">{{ $categoria->nombre }}</td>
                            <td class="td-secundario">{{ $categoria->subcategorias()->count() }}</td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $categoria->activo ? 'activa' : 'inactiva' }}">
                                    {{ $categoria->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="td-acciones">

                                <a href="{{ route('administrador.categorias.editar', $categoria) }}"
                                   class="btn-icono btn-icono--editar"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if($categoria->activo)
                                    <form method="POST"
                                          action="{{ route('administrador.categorias.desactivar', $categoria) }}"
                                          class="form-toggle"
                                          id="form-desactivar-{{ $categoria->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--desactivar"
                                                title="Desactivar categoría"
                                                onclick="confirmarDesactivar('{{ addslashes($categoria->nombre) }}', 'form-desactivar-{{ $categoria->id }}')">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('administrador.categorias.activar', $categoria) }}"
                                          class="form-toggle"
                                          id="form-activar-{{ $categoria->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--activar"
                                                title="Activar categoría"
                                                onclick="confirmarActivar('{{ addslashes($categoria->nombre) }}', 'form-activar-{{ $categoria->id }}')">
                                            <i class="bi bi-toggle-off"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron categorías con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categorias->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $categorias->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/categorias/index.js') }}"></script>
@endpush
