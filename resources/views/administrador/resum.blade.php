@extends('layouts.app')

@section('titulo', 'Resum — Administrador')


@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/incidencias/index.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Resum dashboard</h2>
        </div>
    </div>

    {{-- Selector sede --}}
    <form method="GET" action="{{ route('administrador.resum') }}" class="filtros-bar">
        <label for="sede_id"><strong>Sede:</strong></label>
        <br><br><br>
        <select name="sede_id" id="sede_id" class="filtro-select" onchange="this.form.submit()">
            <option value="">Todas las sedes</option>
            @foreach ($sedes as $sede)
                <option value="{{ $sede->id }}" @selected(request('sede_id') == $sede->id)>
                    {{ $sede->nombre }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Totales por sede --}}
    <h4>Total incidencias resueltas: {{ $totalResueltas }}</h4>
    <h4>Total pendientes: {{ $totalPendientes }}</h4>

    {{-- Tabla técnicos con categorías --}}
    <div class="tabla-card">
        <div class="table-responsive">
            <table class="table tabla-datos mb-0">
                <thead>
                    <tr>
                        <th>Técnico</th>
                        @foreach ($categorias as $categoria)
                            <th>{{ $categoria->nombre }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tecnicos as $tecnico)
                        <tr>
                            <td>{{ $tecnico->nombre }}</td>
                            @foreach ($categorias as $categoria)
                                <td>{{ $conteos[$tecnico->id][$categoria->id] ?? 0 }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $categorias->count() + 1 }}" class="td-vacio">
                                <i class="bi bi-inbox"></i> No hay datos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
