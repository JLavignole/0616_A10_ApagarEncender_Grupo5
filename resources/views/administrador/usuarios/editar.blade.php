@extends('layouts.app')

@section('titulo', 'Editar Usuario - ' . $usuario->nombre)

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/usuarios/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Editar Usuario</h2>
            <p class="seccion-subtitulo">Modificando: <strong>{{ $usuario->nombre }}</strong></p>
        </div>
        <a href="{{ route('administrador.usuarios.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.usuarios.update', $usuario) }}" id="formUsuario" novalidate data-edicion="true">
            @csrf
            @method('PUT')

            @include('administrador.usuarios._campos')

            <div class="form-footer">
                <a href="{{ route('administrador.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/usuarios/form.js') }}"></script>
@endpush
