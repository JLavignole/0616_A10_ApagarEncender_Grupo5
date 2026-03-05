@extends('layouts.app')

@section('titulo', 'Mis Incidencias — Técnico')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/tecnico/incidencias/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Mis incidencias</h2>
            <p class="seccion-subtitulo">{{ $incidencias->total() }} incidencias asignadas</p>
        </div>
    </div>

    <form method="GET" action="{{ route('tecnico.incidencias.index') }}" class="filtros-bar" id="formFiltros">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar por título o código..."
                   autocomplete="off">
        </div>

        <select name="estado" id="selectEstado" class="filtro-select">
            <option value="">Todos los estados</option>
            @foreach (['asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="prioridad" id="selectPrioridad" class="filtro-select">
            <option value="">Toda prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="categoria_id" id="selectCategoria" class="filtro-select">
            <option value="">Categoría</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(request('categoria_id') == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </select>

        <select name="orden" id="selectOrden" class="filtro-select">
            <option value="fecha_desc" @selected(request('orden', 'fecha_desc') === 'fecha_desc')>Más recientes</option>
            <option value="fecha_asc"  @selected(request('orden') === 'fecha_asc')>Más antiguas</option>
        </select>

        @if (request()->hasAny(['buscar', 'estado', 'prioridad', 'categoria_id', 'orden']))
            <a href="{{ route('tecnico.incidencias.index') }}" class="btn-limpiar" title="Limpiar filtros">
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
                        <th>Categoría</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td>
                                <span>{{ $inc->categoria->nombre ?? '—' }}</span>
                                @if ($inc->subcategoria)
                                    <span class="td-sub">{{ $inc->subcategoria->nombre }}</span>
                                @endif
                            </td>
                            <td class="td-secundario">{{ $inc->cliente->nombre ?? '—' }}</td>
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
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                            <td class="td-acciones">
                                @if ($inc->estado === 'asignada')
                                    <form id="form-comenzar-{{ $inc->id }}"
                                          action="{{ route('tecnico.comenzar', $inc) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--comenzar btn-accion-estado"
                                                data-form="form-comenzar-{{ $inc->id }}"
                                                data-codigo="{{ $inc->codigo }}"
                                                data-accion="comenzar"
                                                title="Comenzar trabajo">
                                            <i class="bi bi-play-fill"></i>
                                        </button>
                                    </form>
                                @elseif (in_array($inc->estado, ['en_progreso', 'reabierta']))
                                    <form id="form-resolver-{{ $inc->id }}"
                                          action="{{ route('tecnico.resolver', $inc) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                                class="btn-icono btn-icono--resolver btn-accion-estado"
                                                data-form="form-resolver-{{ $inc->id }}"
                                                data-codigo="{{ $inc->codigo }}"
                                                data-accion="resolver"
                                                title="Resolver incidencia">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('tecnico.incidencias.detalle', $inc) }}"
                                   class="btn-icono btn-icono--ver"
                                   title="Ver detalle">
                                    <i class="bi bi-eye"></i>
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

        @if ($incidencias->hasPages())
            <div class="paginacion-wrapper">
                {{ $incidencias->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/tecnico/incidencias/index.js') }}"></script>
@endpush