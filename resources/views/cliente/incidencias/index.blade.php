@extends('layouts.app')

@section('titulo', 'Mis Incidencias')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Mis incidencias</h2>
            <p class="seccion-subtitulo">{{ $incidencias->total() }} incidencias encontradas</p>
        </div>
        <a href="{{ route('cliente.incidencias.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-circle me-2"></i>Nueva incidencia
        </a>
    </div>

    {{-- ── Filtros ── --}}
    <form method="GET" action="{{ route('cliente.incidencias.index') }}" class="filtros-incidencias">
        <div class="filtro-busqueda">
            <i class="bi bi-search"></i>
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar por título o código...">
        </div>

        <select name="estado" class="filtro-select">
            <option value="">Todos los estados</option>
            @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="prioridad" class="filtro-select">
            <option value="">Toda prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="categoria_id" class="filtro-select">
            <option value="">Toda categoría</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(request('categoria_id') == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </select>

        <div class="filtros-acciones">
            @if(request('ocultar_resueltas'))
                <a href="{{ request()->fullUrlWithQuery(['ocultar_resueltas' => null]) }}" class="btn btn-outline-secondary btn-sm">
                    Mostrar resueltas
                </a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['ocultar_resueltas' => 1]) }}" class="btn btn-outline-secondary btn-sm">
                    Ocultar resueltas
                </a>
            @endif

            <a href="{{ request()->fullUrlWithQuery(['orden' => 'asc']) }}" class="btn btn-outline-primary btn-sm">
                Fecha ASC
            </a>
            <a href="{{ request()->fullUrlWithQuery(['orden' => 'desc']) }}" class="btn btn-outline-primary btn-sm">
                Fecha DESC
            </a>

            @if(request()->hasAny(['buscar', 'estado', 'prioridad', 'categoria_id', 'ocultar_resueltas', 'orden']))
                <a href="{{ route('cliente.incidencias.index') }}" class="btn-limpiar-filtros" title="Limpiar filtros">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>

    {{-- ── Tabla ── --}}
    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Técnico</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidencias as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td>
                                <span class="badge-categoria">{{ $inc->categoria->nombre ?? '—' }}</span>
                                @if ($inc->subcategoria)
                                    <span class="td-sub">{{ $inc->subcategoria->nombre }}</span>
                                @endif
                            </td>
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
                                <a href="{{ route('cliente.incidencias.detalle', $inc) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Ver
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

    {{-- ── Paginación ── --}}
    @if ($incidencias->hasPages())
        <div class="paginacion-wrapper">
            {{ $incidencias->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/incidencias.js') }}"></script>
@endpush
