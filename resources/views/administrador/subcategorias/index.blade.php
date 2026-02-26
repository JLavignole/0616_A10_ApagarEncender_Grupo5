@extends('layouts.app')

@section('titulo', 'Gestión de Subcategorías')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/subcategorias/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Subcategorías</h2>
            <p class="seccion-subtitulo">{{ $subcategorias->total() }} subcategorías en total</p>
        </div>
        <a href="{{ route('administrador.subcategorias.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-lg me-1"></i> Nueva subcategoría
        </a>
    </div>

    <form method="GET" action="{{ route('administrador.subcategorias.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." autocomplete="off">
        </div>

        <div class="filtros-categoria">
            <select name="categoria_id" id="selectCategoria" class="form-select form-select-sm">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}{{ $cat->activo ? '' : ' (inactiva)' }}
                    </option>
                @endforeach
            </select>
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

        @if(request('buscar') || request('categoria_id') || (request('estado') && request('estado') !== 'todas'))
            <a href="{{ route('administrador.subcategorias.index') }}" class="btn-limpiar" title="Limpiar filtros">
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
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategorias as $sub)
                        <tr class="{{ $sub->activo ? '' : 'fila-inactiva' }}">
                            <td class="fw-semibold">{{ $sub->nombre }}</td>
                            <td class="td-secundario">{{ $sub->categoria->nombre ?? '—' }}</td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $sub->activo ? 'activa' : 'inactiva' }}">
                                    {{ $sub->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="td-acciones">

                                <a href="{{ route('administrador.subcategorias.editar', $sub) }}"
                                   class="btn-icono btn-icono--editar"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if($sub->activo)
                                    <form method="POST"
                                          action="{{ route('administrador.subcategorias.desactivar', $sub) }}"
                                          class="form-toggle"
                                          id="form-desactivar-{{ $sub->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--desactivar"
                                                title="Desactivar subcategoría"
                                                onclick="confirmarDesactivar('{{ addslashes($sub->nombre) }}', 'form-desactivar-{{ $sub->id }}')">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('administrador.subcategorias.activar', $sub) }}"
                                          class="form-toggle"
                                          id="form-activar-{{ $sub->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--activar"
                                                title="Activar subcategoría"
                                                onclick="confirmarActivar('{{ addslashes($sub->nombre) }}', 'form-activar-{{ $sub->id }}')">
                                            <i class="bi bi-toggle-off"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron subcategorías con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($subcategorias->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $subcategorias->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/subcategorias/index.js') }}"></script>
@endpush
