@extends('layouts.app')

@section('titulo', 'Mis Incidencias')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')
    <div class="incidencias-layout-fit">

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
    <form id="form-filtros" method="GET" action="{{ route('cliente.incidencias.index') }}" class="filtros-bar">
        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" id="inputBuscar" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título o código...">
        </div>

        <select id="selectEstado" name="estado" class="filtro-select">
            <option value="">Estado</option>
            @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada'] as $val => $label)
                <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select id="selectPrioridad" name="prioridad" class="filtro-select">
            <option value="">Prioridad</option>
            @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <select id="selectCategoria" name="categoria_id" class="filtro-select">
            <option value="">Categoría</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(request('categoria_id') == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-buscar" title="Aplicar filtros">
            <i class="bi bi-search"></i>
        </button>

        <a href="{{ route('cliente.incidencias.index') }}" class="btn-limpiar" title="Limpiar filtros">
            <i class="bi bi-x-lg"></i>
        </a>

    </form>

        <div class="filtro-opciones-extra">
            <a href="{{ request()->fullUrlWithQuery(['ocultar_resueltas' => request('ocultar_resueltas') ? null : 1]) }}" class="link-filtro {{ request('ocultar_resueltas') ? 'active' : '' }}">
                {{ request('ocultar_resueltas') ? 'Mostrar resueltas' : 'Ocultar resueltas' }}
            </a>
            <span class="separador"></span>
            <a href="{{ request()->fullUrlWithQuery(['orden' => request('orden') === 'asc' ? 'desc' : 'asc']) }}" class="link-filtro">
                {{ request('orden') === 'asc' ? 'Recientes' : 'Antiguas' }}
            </a>
        </div>
    </form>

    {{-- ── Tabla y Paginación (Contenedor para AJAX) ── --}}
    <div id="contenedor-incidencias">
        @php
            $estados = [
                'sin_asignar' => 'Sin asignar',
                'asignada' => 'Asignada',
                'en_progreso' => 'En progreso',
                'resuelta' => 'Resuelta',
                'cerrada' => 'Cerrada',
            ];
            $incidenciasPorEstado = $incidencias->getCollection()->groupBy('estado');
        @endphp

        <div class="kanban-grid">
            @foreach ($estados as $estadoKey => $estadoLabel)
                @php
                    $itemsEstado = $incidenciasPorEstado->get($estadoKey, collect());
                @endphp

                <section class="kanban-columna">
                    <div class="kanban-columna-header">
                        <h3>{{ $estadoLabel }}</h3>
                        <span class="kanban-columna-total">{{ $itemsEstado->count() }}</span>
                    </div>

                    <div class="kanban-columna-cuerpo">
                        @forelse ($itemsEstado as $inc)
                            <a href="{{ route('cliente.incidencias.detalle', $inc) }}" class="inc-card">
                                <div class="inc-card-top">
                                    <span class="td-codigo">{{ $inc->codigo }}</span>
                                    <span class="badge-estado badge-estado--{{ $inc->estado }}">
                                        {{ str_replace('_', ' ', ucfirst($inc->estado)) }}
                                    </span>
                                </div>

                                <h4 class="inc-card-titulo">{{ \Illuminate\Support\Str::limit($inc->titulo, 75) }}</h4>

                                <div class="inc-card-meta">
                                    <span class="badge-categoria">{{ $inc->categoria->nombre ?? '—' }}</span>

                                    @if ($inc->prioridad)
                                        <span class="badge-prioridad badge-prioridad--{{ $inc->prioridad }}">
                                            {{ ucfirst($inc->prioridad) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="inc-card-footer">
                                    <span>{{ $inc->tecnico->nombre ?? 'Sin técnico' }}</span>
                                    <span class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="inc-card-vacio">Sin incidencias</div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        </div>

        {{-- ── Paginación ── --}}
        @if ($incidencias->hasPages())
            <div class="paginacion-wrapper">
                {{ $incidencias->links() }}
            </div>
        @endif
    </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/incidencias-filtros.js') }}"></script>
    <script src="{{ asset('js/cliente/incidencias.js') }}"></script>
@endpush
