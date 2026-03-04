@extends('layouts.app')

@section('titulo', 'Gestión de Sanciones')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/sanciones/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Gestión de Sanciones</h2>
            <p class="seccion-subtitulo">{{ $sanciones->total() }} sanciones registradas en total</p>
        </div>
        <a href="{{ route('administrador.sanciones.crear') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-plus-lg me-1"></i> Nueva sanción
        </a>
    </div>

    <form method="GET" action="{{ route('administrador.sanciones.index') }}" id="formFiltros" class="filtros-bar mb-4">

        <div class="filtros-busqueda">
            <i class="bi bi-search"></i>
            <input type="text" name="buscar" id="inputBuscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar por nombre o correo..." autocomplete="off">
        </div>

        <div class="filtros-tipo">
            <select name="tipo" id="selectTipo" class="form-select form-select-sm">
                <option value="todas" {{ $tipo === 'todas' ? 'selected' : '' }}>Todos los tipos</option>
                <option value="advertencia" {{ $tipo === 'advertencia' ? 'selected' : '' }}>Advertencia</option>
                <option value="silencio"    {{ $tipo === 'silencio'    ? 'selected' : '' }}>Silencio</option>
                <option value="bloqueo"     {{ $tipo === 'bloqueo'     ? 'selected' : '' }}>Bloqueo</option>
            </select>
        </div>

        <div class="filtros-estado">
            <button type="button" id="btnEstadoTodas"
                    class="btn-filtro-estado {{ $estado === 'todas' ? 'activo' : '' }}">Todas</button>
            <button type="button" id="btnEstadoActivas"
                    class="btn-filtro-estado {{ $estado === 'activas' ? 'activo' : '' }}">Activas</button>
            <button type="button" id="btnEstadoFinalizadas"
                    class="btn-filtro-estado {{ $estado === 'finalizadas' ? 'activo' : '' }}">Finalizadas</button>
            <input type="hidden" name="estado" id="inputEstado" value="{{ $estado }}">
        </div>

        @if(request('buscar') || (request('tipo') && request('tipo') !== 'todas') || (request('estado') && request('estado') !== 'todas'))
            <a href="{{ route('administrador.sanciones.index') }}" class="btn-limpiar" title="Limpiar filtros">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif

    </form>

    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Motivo</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                        <th>Creado por</th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanciones as $sancion)
                        @php
                            $ahora  = now();
                            $activa = (is_null($sancion->inicio_en) || $sancion->inicio_en <= $ahora)
                                   && (is_null($sancion->fin_en)    || $sancion->fin_en    >  $ahora);
                        @endphp
                        <tr class="{{ $activa ? '' : 'fila-finalizada' }}">
                            <td>
                                <div class="fw-semibold">{{ $sancion->usuario->nombre ?? '—' }}</div>
                                <div class="td-email">{{ $sancion->usuario->correo ?? '' }}</div>
                            </td>
                            <td>
                                <span class="badge-tipo badge-tipo--{{ $sancion->tipo }}">
                                    @if($sancion->tipo === 'advertencia')
                                        <i class="bi bi-exclamation-triangle me-1"></i>Advertencia
                                    @elseif($sancion->tipo === 'silencio')
                                        <i class="bi bi-mic-mute me-1"></i>Silencio
                                    @else
                                        <i class="bi bi-slash-circle me-1"></i>Bloqueo
                                    @endif
                                </span>
                            </td>
                            <td class="td-motivo" title="{{ $sancion->motivo }}">
                                {{ \Illuminate\Support\Str::limit($sancion->motivo, 50) }}
                            </td>
                            <td class="td-secundario">
                                {{ isset($sancion->inicio_en) ? $sancion->inicio_en->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td class="td-secundario">
                                {{ isset($sancion->fin_en) ? $sancion->fin_en->format('d/m/Y H:i') : 'Indefinida' }}
                            </td>
                            <td>
                                <span class="badge-estado badge-estado--{{ $activa ? 'activa' : 'finalizada' }}">
                                    {{ $activa ? 'Activa' : 'Finalizada' }}
                                </span>
                            </td>
                            <td class="td-secundario">
                                {{ $sancion->creadoPor->nombre ?? '—' }}
                            </td>
                            <td class="td-acciones">
                                @if($activa)
                                    <form method="POST"
                                          action="{{ route('administrador.sanciones.finalizar', $sancion) }}"
                                          class="form-toggle"
                                          id="form-finalizar-{{ $sancion->id }}">
                                        @csrf
                                        <button type="button"
                                                class="btn-icono btn-icono--finalizar"
                                                title="Finalizar sanción"
                                                onclick="confirmarFinalizar('{{ addslashes($sancion->usuario->nombre ?? '') }}', 'form-finalizar-{{ $sancion->id }}')">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="sin-accion" title="Sanción ya finalizada">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="td-vacio">
                                <i class="bi bi-inbox"></i> No se encontraron sanciones con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($sanciones->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $sanciones->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/sanciones/index.js') }}"></script>
@endpush
