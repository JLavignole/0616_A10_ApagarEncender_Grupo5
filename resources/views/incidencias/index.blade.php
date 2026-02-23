@extends('layouts.panel')

@section('title', 'Incidencias – TechTrack')

@section('content')
    {{-- ═══ Cabecera ═══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tablón de Incidencias</h1>
            <p class="page-subtitle">{{ $incidencias->total() }} incidencias registradas</p>
        </div>
        <a href="#" class="btn-add">
            <i class="fa-solid fa-plus"></i> Añadir Incidencia
        </a>
    </div>

    {{-- ═══ Filtros ═══ --}}
    <form method="GET" action="{{ route('incidencias.index') }}" class="filters-bar">
        <div class="filter-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título o código...">
        </div>

        <select name="estado">
            <option value="">Todos los estados</option>
            @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="prioridad">
            <option value="">Toda prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="categoria_id">
            <option value="">Toda categoría</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(request('categoria_id') == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </select>

        @if(request()->hasAny(['buscar', 'estado', 'prioridad', 'categoria_id']))
            <a href="{{ route('incidencias.index') }}" class="btn-clear-filters" title="Limpiar filtros">
                <i class="fa-solid fa-xmark"></i>
            </a>
        @endif
    </form>

    {{-- ═══ Tabla ═══ --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="th-status"></th>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Cliente</th>
                    <th>Técnico</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th class="th-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incidencias as $inc)
                    <tr>
                        {{-- Indicador de estado (punto de color) --}}
                        <td class="td-status">
                            <span class="status-dot status-dot--{{ $inc->estado }}"></span>
                        </td>

                        {{-- Código --}}
                        <td class="td-code">{{ $inc->codigo }}</td>

                        {{-- Título --}}
                        <td class="td-title">{{ Str::limit($inc->titulo, 40) }}</td>

                        {{-- Categoría / Subcategoría --}}
                        <td>
                            <span class="badge badge--category">{{ $inc->categoria->nombre }}</span>
                            @if($inc->subcategoria)
                                <span class="td-sub">{{ $inc->subcategoria->nombre }}</span>
                            @endif
                        </td>

                        {{-- Cliente --}}
                        <td>{{ $inc->cliente->nombre ?? '—' }}</td>

                        {{-- Técnico --}}
                        <td>{{ $inc->tecnico->nombre ?? '—' }}</td>

                        {{-- Prioridad --}}
                        <td>
                            @if($inc->prioridad)
                                <span class="badge badge--{{ $inc->prioridad }}">
                                    {{ ucfirst($inc->prioridad) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td>
                            <span class="badge badge--estado badge--{{ $inc->estado }}">
                                {{ str_replace('_', ' ', ucfirst($inc->estado)) }}
                            </span>
                        </td>

                        {{-- Fecha --}}
                        <td class="td-date">
                            {{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}
                        </td>

                        {{-- Acciones --}}
                        <td class="td-actions">
                            <a href="#" class="action-btn action-btn--view" title="Ver detalle">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#" class="action-btn action-btn--edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" class="action-btn action-btn--delete" title="Eliminar">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="td-empty">
                            <i class="fa-solid fa-inbox"></i>
                            <p>No se encontraron incidencias</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ Paginación ═══ --}}
    @if ($incidencias->hasPages())
        <div class="pagination-wrapper">
            {{ $incidencias->links() }}
        </div>
    @endif
@endsection
