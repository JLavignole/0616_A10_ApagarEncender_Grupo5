@extends('layouts.app')

@section('titulo', 'Crear Incidencia')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ── --}}
    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Nueva incidencia</h2>
            <p class="seccion-subtitulo">Rellena los datos para reportar un problema</p>
        </div>
        <a href="{{ route('cliente.incidencias.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    {{-- ── Formulario ── --}}
    <div class="crear-card">
        <form method="POST"
              action="{{ route('cliente.incidencias.store') }}"
              enctype="multipart/form-data"
              novalidate>
            @csrf

            {{-- Título --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                <input type="text"
                       id="titulo"
                       name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo') }}"
                       placeholder="Describe brevemente el problema"
                       required>
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Categoría --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select id="categoria_id"
                            name="categoria_id"
                            class="form-select @error('categoria_id') is-invalid @enderror"
                            required>
                        <option value="">Selecciona categoría...</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected(old('categoria_id') == $cat->id)>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subcategoría (cargada por AJAX) --}}
                <div class="col-md-6">
                    <label for="subcategoria_id" class="form-label">Subcategoría <span class="text-danger">*</span></label>
                    <select id="subcategoria_id"
                            name="subcategoria_id"
                            class="form-select @error('subcategoria_id') is-invalid @enderror"
                            disabled
                            required>
                        <option value="">Selecciona subcategoría...</option>
                    </select>
                    @error('subcategoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion"
                          name="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          rows="5"
                          placeholder="Explica el problema con todo el detalle posible..."
                          required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Imagen adjunta (opcional) --}}
            <div class="mb-4">
                <label for="imagen" class="form-label">Imagen adjunta <span class="text-muted">(opcional, máx. 3 MB)</span></label>
                <input type="file"
                       id="imagen"
                       name="imagen"
                       class="form-control @error('imagen') is-invalid @enderror"
                       accept="image/*">
                @error('imagen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <img id="imagen-preview" class="imagen-preview" alt="Vista previa">
            </div>

            {{-- Botón enviar --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-accion">
                    <i class="bi bi-send me-2"></i>Enviar incidencia
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/incidencias.js') }}"></script>
@endpush
