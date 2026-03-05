@extends('layouts.app')

@section('titulo', 'Gestión de Incidencias')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/incidencias/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Incidencias</h2>
            <p class="seccion-subtitulo">{{ $incidencias->total() }} incidencias en total</p>
        </div>
    </div>

    <form method="GET" action="{{ route('administrador.incidencias.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar" value="{{ request('buscar') }}" placeholder="Buscar por título o código..." autocomplete="off">
        </div>

        <select name="estado" id="selectEstado" class="filtro-select">
            <option value="">Estado</option>
            @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada', 'reabierta' => 'Reabierta'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="prioridad" id="selectPrioridad" class="filtro-select">
            <option value="">Prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="sede_id" id="selectSede" class="filtro-select">
            <option value="">Todas las sedes</option>
            @foreach ($sedes as $sede)
                <option value="{{ $sede->id }}" @selected(request('sede_id') == $sede->id)>{{ $sede->nombre }}</option>
            @endforeach
        </select>

        <select name="orden" id="selectOrden" class="filtro-select">
            <option value="fecha_desc" @selected(request('orden', 'fecha_desc') === 'fecha_desc')>Más recientes</option>
            <option value="fecha_asc" @selected(request('orden') === 'fecha_asc')>Más antiguas</option>
        </select>

        @if (request()->hasAny(['buscar', 'estado', 'prioridad', 'sede_id', 'orden']))
            <a href="{{ route('administrador.incidencias.index') }}" class="btn-limpiar" title="Limpiar filtros">
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
                        <th>Título</th>
                        <th>Sede</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Técnico</th>
                        <th>Fecha</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td class="td-secundario">{{ $inc->sede->nombre ?? '—' }}</td>
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
                            <td class="td-secundario">{{ $inc->tecnico->nombre ?? '—' }}</td>
                            <td class="td-secundario">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                            <td class="td-acciones">
                                <a href="{{ route('administrador.incidencias.editar', $inc) }}"
                                   class="btn-icono btn-icono--editar"
                                   title="Editar incidencia">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron incidencias
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($incidencias->hasPages())
        <div class="paginacion-wrapper">
            {{ $incidencias->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/incidencias/index.js') }}"></script>
@endpush
