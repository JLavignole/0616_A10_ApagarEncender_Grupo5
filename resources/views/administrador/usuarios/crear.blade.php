@extends('layouts.app')

@section('titulo', 'Nuevo Usuario')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/usuarios/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Nuevo Usuario</h2>
            <p class="seccion-subtitulo">Rellena los datos para dar de alta un nuevo usuario.</p>
        </div>
        <a href="{{ route('administrador.usuarios.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.usuarios.store') }}" id="formUsuario" novalidate data-edicion="false">
            @csrf

            @include('administrador.usuarios._campos')

            <div class="form-footer">
                <a href="{{ route('administrador.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar usuario
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/usuarios/form.js') }}"></script>
@endpush
