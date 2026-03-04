@extends('layouts.app')

@section('titulo', 'Editar Categoría - ' . $categoria->nombre)

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/categorias/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Editar Categoría</h2>
            <p class="seccion-subtitulo">Modificando: <strong>{{ $categoria->nombre }}</strong></p>
        </div>
        <a href="{{ route('administrador.categorias.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.categorias.update', $categoria) }}" id="formCategoria" novalidate>
            @csrf
            @method('PUT')

            @include('administrador.categorias._campos')

            <div class="form-footer">
                <a href="{{ route('administrador.categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/categorias/form.js') }}"></script>
@endpush
