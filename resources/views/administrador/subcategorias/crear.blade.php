@extends('layouts.app')

@section('titulo', 'Nueva Subcategoría')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/subcategorias/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Nueva Subcategoría</h2>
            <p class="seccion-subtitulo">Rellena los datos para crear una nueva subcategoría de incidencias.</p>
        </div>
        <a href="{{ route('administrador.subcategorias.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST"
              action="{{ route('administrador.subcategorias.store') }}"
              id="formSubcategoria"
              data-url-por-categoria="{{ route('administrador.subcategorias.porCategoria', ['id' => '__ID__']) }}"
              novalidate>
            @csrf

            @include('administrador.subcategorias._campos')

            <div class="form-footer">
                <a href="{{ route('administrador.subcategorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar subcategoría
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/subcategorias/form.js') }}"></script>
@endpush
