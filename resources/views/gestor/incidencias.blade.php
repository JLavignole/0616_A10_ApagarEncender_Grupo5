@extends('layouts.app')

@section('titulo', 'Incidencias — Gestor')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/gestor/incidencias.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Incidencias</h2>
            <p class="seccion-subtitulo">{{ $incidencias->total() }} incidencias en {{ $usuario->sede->nombre ?? 'tu sede' }}</p>
        </div>
    </div>

    {{-- ── Filtros ── --}}
    <form method="GET" action="{{ route('gestor.incidencias') }}" class="filtros-barra" id="formFiltros">
        <div class="filtro-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título o código...">
        </div>

        <select name="estado" class="filtro-select" onchange="document.getElementById('formFiltros').submit()">
            <option value="">Todos los estados</option>
            @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="prioridad" class="filtro-select" onchange="document.getElementById('formFiltros').submit()">
            <option value="">Toda prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="orden" class="filtro-select" onchange="document.getElementById('formFiltros').submit()">
            <option value="fecha_desc" @selected(request('orden') === 'fecha_desc')>Más recientes</option>
            <option value="fecha_asc" @selected(request('orden') === 'fecha_asc')>Más antiguas</option>
            <option value="prioridad_asc" @selected(request('orden') === 'prioridad_asc')>Prioridad ↑</option>
            <option value="prioridad_desc" @selected(request('orden') === 'prioridad_desc')>Prioridad ↓</option>
        </select>

        <label class="filtro-check">
            <input type="checkbox" id="chkOcultarCerradas"> Ocultar cerradas
        </label>

        @if(request()->hasAny(['buscar', 'estado', 'prioridad', 'orden']))
            <a href="{{ route('gestor.incidencias') }}" class="filtro-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </form>

    {{-- ── Tabla ── --}}
    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0" id="tablaIncidencias">
                <thead>
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Cliente</th>
                        <th>Técnico</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidencias as $inc)
                        <tr class="fila-incidencia" data-estado="{{ $inc->estado }}">
                            <td>
                                <span class="estado-dot estado-dot--{{ $inc->estado }}"></span>
                            </td>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td>
                                <span class="badge-cat">{{ $inc->categoria->nombre ?? '—' }}</span>
                                @if($inc->subcategoria)
                                    <span class="td-sub">{{ $inc->subcategoria->nombre }}</span>
                                @endif
                            </td>
                            <td>{{ $inc->cliente->nombre ?? '—' }}</td>
                            <td>{{ $inc->tecnico->nombre ?? '—' }}</td>
                            <td>
                                @if ($inc->prioridad)
                                    <span class="badge-prioridad badge-prioridad--{{ $inc->prioridad }}">
                                        {{ ucfirst($inc->prioridad) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $inc->estado }}">
                                    {{ str_replace('_', ' ', ucfirst($inc->estado)) }}
                                </span>
                            </td>
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                            <td class="td-acciones">
                                <a href="{{ route('gestor.incidencias.show', $inc->id) }}" class="accion-btn accion-btn--ver" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if ($inc->estado === 'sin_asignar')
                                    <button type="button"
                                            class="accion-btn accion-btn--asignar btn-abrir-asignar"
                                            title="Asignar"
                                            data-id="{{ $inc->id }}"
                                            data-codigo="{{ $inc->codigo }}"
                                            data-url="{{ route('gestor.incidencias.asignar', $inc->id) }}">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="td-vacio">
                                <i class="bi bi-inbox"></i>
                                No se encontraron incidencias
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Paginación ── --}}
    @if ($incidencias->hasPages())
        <div class="paginacion-wrapper">
            {{ $incidencias->links() }}
        </div>
    @endif

    {{-- ── Modal de asignación ── --}}
    <div class="modal-overlay" id="modalAsignar" hidden>
        <div class="modal-caja">
            <div class="modal-cabecera">
                <h4 class="modal-titulo">Asignar incidencia <span id="modalCodigoInc"></span></h4>
                <button type="button" class="modal-cerrar" id="btnCerrarModal">&times;</button>
            </div>
            <div class="modal-cuerpo">
                <div class="campo-grupo">
                    <label for="selectPrioridad" class="campo-label">Prioridad</label>
                    <select id="selectPrioridad" class="campo-select">
                        <option value="">— Seleccionar —</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>
                <div class="campo-grupo">
                    <label for="selectTecnico" class="campo-label">Técnico</label>
                    <select id="selectTecnico" class="campo-select">
                        <option value="">— Seleccionar técnico —</option>
                        @foreach ($tecnicos as $tec)
                            <option value="{{ $tec->id }}">{{ $tec->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-pie">
                <button type="button" class="btn btn-secondary" id="btnCancelarModal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarAsignar">
                    <i class="bi bi-check-lg me-1"></i>Asignar
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/gestor/incidencias.js') }}"></script>
@endpush
