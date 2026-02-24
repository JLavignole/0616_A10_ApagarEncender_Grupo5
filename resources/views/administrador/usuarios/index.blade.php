@extends('layouts.app')

@section('titulo', 'Gestión de Usuarios')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/usuarios/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Usuarios</h2>
            <p class="seccion-subtitulo">{{ $usuarios->total() }} usuarios en total</p>
        </div>
        <a href="{{ route('administrador.usuarios.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-lg me-1"></i> Nuevo usuario
        </a>
    </div>

    <form method="GET" action="{{ route('administrador.usuarios.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o correo..." autocomplete="off">
        </div>

        <select name="sede_id" id="selectSede" class="filtro-select">
            <option value="">Todas las sedes</option>
            @foreach($sedes as $sede)
                <option value="{{ $sede->id }}" {{ request('sede_id') == $sede->id ? 'selected' : '' }}>
                    {{ $sede->nombre }}
                </option>
            @endforeach
        </select>

        <select name="rol_id" id="selectRol" class="filtro-select">
            <option value="">Todos los roles</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}" {{ request('rol_id') == $rol->id ? 'selected' : '' }}>
                    {{ ucfirst($rol->nombre) }}
                </option>
            @endforeach
        </select>

        <div class="filtros-estado">
            <button type="button" id="btnEstadoTodos"
                    class="btn-filtro-estado {{ $estado === 'todos' ? 'activo' : '' }}">Todos</button>
            <button type="button" id="btnEstadoActivos"
                    class="btn-filtro-estado {{ $estado === 'activos' ? 'activo' : '' }}">Activos</button>
            <button type="button" id="btnEstadoInactivos"
                    class="btn-filtro-estado {{ $estado === 'inactivos' ? 'activo' : '' }}">Inactivos</button>
            <input type="hidden" name="estado" id="inputEstado" value="{{ $estado }}">
        </div>

        @if(request('buscar') || request('sede_id') || request('rol_id') || (request('estado') && request('estado') !== 'todos'))
            <a href="{{ route('administrador.usuarios.index') }}" class="btn-limpiar" title="Limpiar filtros">
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
                        <th>Correo</th>
                        <th>Sede</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr class="{{ $usuario->activo ? '' : 'fila-inactiva' }}">
                            <td class="fw-semibold">{{ $usuario->nombre }}</td>
                            <td class="td-secundario">{{ $usuario->correo }}</td>
                            <td class="td-secundario">{{ $usuario->sede?->nombre ?? '—' }}</td>
                            <td>
                                <span class="badge-rol badge-rol--{{ $usuario->rol?->nombre ?? 'sin-rol' }}">
                                    {{ ucfirst($usuario->rol?->nombre ?? 'Sin rol') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $usuario->activo ? 'activo' : 'inactivo' }}">
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="td-acciones">

                                <a href="{{ route('administrador.usuarios.editar', $usuario) }}"
                                   class="btn-icono btn-icono--editar"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if($usuario->activo)
                                    <form method="POST"
                                          action="{{ route('administrador.usuarios.desactivar', $usuario) }}"
                                          class="form-toggle"
                                          id="form-desactivar-{{ $usuario->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--desactivar"
                                                title="Desactivar usuario"
                                                onclick="confirmarDesactivar('{{ addslashes($usuario->nombre) }}', 'form-desactivar-{{ $usuario->id }}')">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('administrador.usuarios.reactivar', $usuario) }}"
                                          class="form-toggle"
                                          id="form-reactivar-{{ $usuario->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--activar"
                                                title="Reactivar usuario"
                                                onclick="confirmarReactivar('{{ addslashes($usuario->nombre) }}', 'form-reactivar-{{ $usuario->id }}')">
                                            <i class="bi bi-toggle-off"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron usuarios con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($usuarios->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $usuarios->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/usuarios/index.js') }}"></script>
@endpush
