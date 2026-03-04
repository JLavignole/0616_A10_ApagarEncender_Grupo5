@extends('layouts.app')

@section('titulo', 'Carga de técnicos — Gestor')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/gestor/tecnicos.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Carga de técnicos</h2>
            <p class="seccion-subtitulo">Incidencias asignadas a cada técnico de {{ $usuario->sede->nombre ?? 'tu sede' }}</p>
        </div>
    </div>

    <div class="row g-3">
        @forelse ($tecnicos as $tec)
            @php
                $total = $tec->incidenciasTecnico->count();
            @endphp
            <div class="col-12 col-lg-6">
                <div class="tecnico-card">
                    <div class="tecnico-cabecera" data-toggle="tecnico">
                        <div class="tecnico-info">
                            <div class="tecnico-avatar">
                                {{ strtoupper(substr($tec->nombre, 0, 1)) }}
                            </div>
                            <div>
                                <span class="tecnico-nombre">{{ $tec->nombre }}</span>
                                <span class="tecnico-correo">{{ $tec->correo }}</span>
                            </div>
                        </div>
                        <div class="tecnico-contador">
                            <span class="tecnico-badge {{ $total > 5 ? 'tecnico-badge--rojo' : ($total > 2 ? 'tecnico-badge--naranja' : 'tecnico-badge--verde') }}">
                                {{ $total }} {{ $total === 1 ? 'incidencia' : 'incidencias' }}
                            </span>
                            <i class="bi bi-chevron-down tecnico-flecha"></i>
                        </div>
                    </div>

                    <div class="tecnico-lista" hidden>
                        @if ($total > 0)
                            <table class="table tabla-datos mb-0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Título</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tec->incidenciasTecnico as $inc)
                                        <tr>
                                            <td class="td-codigo">
                                                <a href="{{ route('gestor.incidencias.show', $inc->id) }}">{{ $inc->codigo }}</a>
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($inc->titulo, 35) }}</td>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="tecnico-sin-inc">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                Sin incidencias activas
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="tabla-card">
                    <div class="td-vacio" style="padding: 3rem;">
                        <i class="bi bi-person-x"></i>
                        No hay técnicos activos en tu sede
                    </div>
                </div>
            </div>
        @endforelse
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/gestor/tecnicos.js') }}"></script>
@endpush
