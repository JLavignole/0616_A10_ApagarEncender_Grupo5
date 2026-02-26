@extends('layouts.app')

@section('titulo', 'Dashboard — Gestor')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/gestor/dashboard.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Panel del Gestor</h2>
            <p class="seccion-subtitulo">Estado actual de las incidencias en {{ $usuario->sede->nombre ?? 'tu sede' }}</p>
        </div>
        <a href="{{ route('gestor.tecnicos') }}" class="btn btn-primary btn-accion">
            <i class="bi bi-bar-chart-line me-2"></i>Carga por técnico
        </a>
    </div>

    {{-- ── KPIs ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-rojo">
                    <i class="bi bi-clipboard-x-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasSinAsignar }}</div>
                    <div class="tarjeta-kpi-etiqueta">Sin asignar</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-naranja">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasEnProgreso }}</div>
                    <div class="tarjeta-kpi-etiqueta">En progreso</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-verde">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $incidenciasResueltas }}</div>
                    <div class="tarjeta-kpi-etiqueta">Resueltas</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="tarjeta-kpi">
                <div class="tarjeta-kpi-icono kpi-azul">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="tarjeta-kpi-info">
                    <div class="tarjeta-kpi-valor">{{ $tecnicosActivos }}</div>
                    <div class="tarjeta-kpi-etiqueta">Técnicos activos</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Incidencias sin asignar ── --}}
    <div class="tabla-card">
        <div class="tabla-card-header">
            <h3 class="tabla-card-titulo">Incidencias pendientes de asignación</h3>
            <a href="{{ route('gestor.incidencias') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
        </div>
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendientes as $inc)
                        <tr>
                            <td class="td-codigo">{{ $inc->codigo }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 40) }}</td>
                            <td>{{ $inc->categoria->nombre ?? '—' }}</td>
                            <td>{{ $inc->cliente->nombre ?? '—' }}</td>
                            <td class="td-fecha">{{ $inc->reportado_en?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary btn-abrir-asignar"
                                        data-id="{{ $inc->id }}"
                                        data-codigo="{{ $inc->codigo }}"
                                        data-url="{{ route('gestor.incidencias.asignar', $inc->id) }}">
                                    <i class="bi bi-person-plus me-1"></i>Asignar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td-vacio">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                No hay incidencias pendientes de asignación
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
    <script src="{{ asset('js/gestor/dashboard.js') }}"></script>
@endpush
