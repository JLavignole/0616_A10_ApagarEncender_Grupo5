@extends('layouts.app')

@section('titulo', 'Editar Sede - ' . $sede->nombre)

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/sedes/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Editar Sede</h2>
            <p class="seccion-subtitulo">Modificando: <strong>{{ $sede->nombre }}</strong> ({{ $sede->codigo }})</p>
        </div>
        <a href="{{ route('administrador.sedes.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.sedes.update', $sede) }}" id="formSede" novalidate>
            @csrf
            @method('PUT')

            @include('administrador.sedes._campos', ['sede' => $sede])

            <div class="form-footer">
                <a href="{{ route('administrador.sedes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/sedes/form.js') }}"></script>
@endpush
