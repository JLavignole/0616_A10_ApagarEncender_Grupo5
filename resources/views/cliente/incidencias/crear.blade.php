@extends('layouts.app')

@section('titulo', 'Crear Incidencia')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/cliente/incidencias.css') }}">
@endpush

@section('contenido')
    <div class="crear-wrapper">
        <a href="{{ route('cliente.incidencias.index') }}" class="crear-back-link">
            <i class="bi bi-arrow-left"></i>
            Nueva incidencia
        </a>

        <div class="crear-card crear-card-modern">
            <form method="POST"
                  action="{{ route('cliente.incidencias.store') }}"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf

                <div class="crear-card-head">
                    <div>
                        <h2 class="crear-card-titulo">Detalles del problema</h2>
                        <p class="crear-card-subtitulo">Completa la información para que podamos asignarte un técnico.</p>
                    </div>
                    <span class="crear-estado-pill">
                        <i class="bi bi-clock"></i> Sin asignar
                    </span>
                </div>

                <div class="crear-card-body">
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select id="categoria_id"
                                    name="categoria_id"
                                    class="form-select @error('categoria_id') is-invalid @enderror"
                                    required>
                                <option value="">Seleccionar opción...</option>
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

                        <div class="col-md-6">
                            <label for="subcategoria_id" class="form-label">Subcategoría <span class="text-danger">*</span></label>
                            <select id="subcategoria_id"
                                    name="subcategoria_id"
                                    class="form-select @error('subcategoria_id') is-invalid @enderror"
                                    disabled
                                    required>
                                <option value="">Seleccionar opción...</option>
                            </select>
                            @error('subcategoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Descripción corta <span class="text-danger">*</span></label>
                        <input type="text"
                               id="titulo"
                               name="titulo"
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}"
                               placeholder="Ej: La impresora del pasillo 3 no enciende"
                               required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Detalles adicionales</label>
                        <textarea id="descripcion"
                                  name="descripcion"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  rows="5"
                                  placeholder="Describe el problema con más detalle, pasos para reproducirlo, o cualquier observación relevante..."
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="imagen" class="form-label">Adjuntar foto o captura</label>
                        <input type="file"
                               id="imagen"
                               name="imagen"
                               class="file-input-hidden @error('imagen') is-invalid @enderror"
                               accept="image/*">

                        <label for="imagen" class="upload-dropzone">
                            <i class="bi bi-card-image"></i>
                            <p><strong>Haz clic para subir</strong> o arrastra y suelta</p>
                            <small>JPG, PNG o GIF (máx. 3MB)</small>
                        </label>

                        @error('imagen')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <img id="imagen-preview" class="imagen-preview" alt="Vista previa">
                    </div>
                </div>

                <div class="crear-card-footer">
                    <a href="{{ route('cliente.incidencias.index') }}" class="btn btn-light btn-cancelar-crear">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-guardar-crear">Guardar Incidencia</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/cliente/incidencias.js') }}"></script>
@endpush
