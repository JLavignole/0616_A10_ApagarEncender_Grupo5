@extends('layouts.app')

@section('titulo', 'Nueva Sede')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/sedes/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Nueva Sede</h2>
            <p class="seccion-subtitulo">Rellena los datos para dar de alta una nueva sede.</p>
        </div>
        <a href="{{ route('administrador.sedes.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.sedes.store') }}" id="formSede" novalidate>
            @csrf

            @include('administrador.sedes._campos', ['sede' => null])

            <div class="form-footer">
                <a href="{{ route('administrador.sedes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar sede
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/sedes/form.js') }}"></script>
@endpush
