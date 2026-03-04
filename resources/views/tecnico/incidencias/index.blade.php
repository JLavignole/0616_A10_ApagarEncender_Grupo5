@extends('layouts.app')

@section('titulo', 'Mis Incidencias')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Listado de incidencias</h2>
            <p class="seccion-subtitulo">{{ $incidencias->total() }} incidencias encontradas</p>
        </div>
    </div>

    {{-- ── Filtros ── --}}
    <form method="GET" action="{{ route('tecnico.incidencias.index') }}" class="filtros-simple">
        <div class="filtro-campo-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título o código...">
        </div>

        <div class="filtro-controles">
            <select name="estado" class="filtro-mini-select">
                <option value="">Estado</option>
                @foreach (['asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('estado') === $val)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="prioridad" class="filtro-mini-select">
                <option value="">Prioridad</option>
                @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('prioridad') === $val)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="categoria_id" class="filtro-mini-select">
                <option value="">Categoría</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" @selected(request('categoria_id') == $cat->id)>{{ $cat->nombre }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filtro-simple" title="Aplicar filtros">
                <i class="bi bi-filter"></i>
            </button>

            <a href="{{ route('tecnico.incidencias.index') }}" class="btn-limpiar-simple" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
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
                        <th>Fecha</th>
                        <th class="text-end">Acciones</th>
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
                                    <span class="td-sub d-block small text-muted">{{ $inc->subcategoria->nombre }}</span>
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
                            
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y') ?? '—' }}</td>
                            
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center">
        
                                    {{-- ACCION 1: De 'asignada' a 'en_progreso' --}}
                                    @if($inc->estado === 'asignada')
                                        <form action="{{ route('tecnico.comenzar', $inc->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary" title="Empezar a trabajar">
                                                <i class="bi bi-play-fill"></i> Comenzar
                                            </button>
                                        </form>

                                    {{-- ACCION 2: De "en_progreso" a "resuelta" --}}
                                    @elseif($inc->estado === 'en_progreso')
                                        <form action="{{ route('tecnico.resolver', $inc->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH') {{-- ESTA ES LA LÍNEA QUE FALTA --}}
                                            <button type="submit" class="btn btn-sm btn-success" title="Resolver">
                                                <i class="bi bi-check-lg"></i> Resolver
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Botón ver detalle --}}
                                    <a href="{{ route('tecnico.incidencias.detalle', $inc->id) }}" 
                                    class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="td-vacio">
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
        <div class="paginacion-wrapper mt-4">
            {{ $incidencias->links() }}
        </div>
    @endif

@endsection