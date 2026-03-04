@extends('layouts.app')

@section('titulo', 'Editar Incidencia — ' . $incidencia->codigo)

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/incidencias/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Editar Incidencia</h2>
            <p class="seccion-subtitulo">Modificando: <strong>{{ $incidencia->codigo }}</strong> — {{ \Illuminate\Support\Str::limit($incidencia->titulo, 60) }}</p>
        </div>
        <a href="{{ route('administrador.incidencias.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST"
              action="{{ route('administrador.incidencias.update', $incidencia) }}"
              id="formIncidencia"
              novalidate
              data-url-subcategorias="{{ route('subcategorias.porCategoria', '__ID__') }}"
              data-subcategoria-actual="{{ old('subcategoria_id', $incidencia->subcategoria_id) }}">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">
                    Título <span class="texto-requerido">*</span>
                </label>
                <input type="text"
                       id="titulo"
                       name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo', $incidencia->titulo) }}"
                       required>
                <div class="invalid-feedback">
                    @error('titulo'){{ $message }}@enderror
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mb-3">
                <label for="descripcion" class="form-label">
                    Descripción <span class="texto-requerido">*</span>
                </label>
                <textarea id="descripcion"
                          name="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          rows="4"
                          required>{{ old('descripcion', $incidencia->descripcion) }}</textarea>
                <div class="invalid-feedback">
                    @error('descripcion'){{ $message }}@enderror
                </div>
            </div>

            {{-- Categoría + Subcategoría --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">
                        Categoría <span class="texto-requerido">*</span>
                    </label>
                    <select id="categoria_id"
                            name="categoria_id"
                            class="form-select @error('categoria_id') is-invalid @enderror"
                            required>
                        <option value="">Selecciona categoría...</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected(old('categoria_id', $incidencia->categoria_id) == $cat->id)>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('categoria_id'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="subcategoria_id" class="form-label">
                        Subcategoría <span class="texto-requerido">*</span>
                    </label>
                    <select id="subcategoria_id"
                            name="subcategoria_id"
                            class="form-select @error('subcategoria_id') is-invalid @enderror"
                            required>
                        @if ($incidencia->subcategoria)
                            <option value="{{ $incidencia->subcategoria_id }}" selected>
                                {{ $incidencia->subcategoria->nombre }}
                            </option>
                        @else
                            <option value="">Selecciona subcategoría...</option>
                        @endif
                    </select>
                    <div class="invalid-feedback">
                        @error('subcategoria_id'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- Estado + Prioridad --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="estado" class="form-label">
                        Estado <span class="texto-requerido">*</span>
                    </label>
                    <select id="estado"
                            name="estado"
                            class="form-select @error('estado') is-invalid @enderror"
                            required>
                        @foreach (['sin_asignar' => 'Sin asignar', 'asignada' => 'Asignada', 'en_progreso' => 'En progreso', 'resuelta' => 'Resuelta', 'cerrada' => 'Cerrada', 'reabierta' => 'Reabierta'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('estado', $incidencia->estado) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('estado'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="prioridad" class="form-label">Prioridad</label>
                    <select id="prioridad"
                            name="prioridad"
                            class="form-select @error('prioridad') is-invalid @enderror">
                        <option value="">Sin prioridad</option>
                        @foreach (['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('prioridad', $incidencia->prioridad) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('prioridad'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- Sede --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sede_id" class="form-label">
                        Sede <span class="texto-requerido">*</span>
                    </label>
                    <select id="sede_id"
                            name="sede_id"
                            class="form-select @error('sede_id') is-invalid @enderror"
                            required>
                        <option value="">Selecciona sede...</option>
                        @foreach ($sedes as $sede)
                            <option value="{{ $sede->id }}" @selected(old('sede_id', $incidencia->sede_id) == $sede->id)>
                                {{ $sede->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('sede_id'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- Técnico + Gestor --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="tecnico_id" class="form-label">Técnico asignado</label>
                    <select id="tecnico_id"
                            name="tecnico_id"
                            class="form-select @error('tecnico_id') is-invalid @enderror">
                        <option value="">Sin técnico</option>
                        @foreach ($tecnicos as $tec)
                            <option value="{{ $tec->id }}" @selected(old('tecnico_id', $incidencia->tecnico_id) == $tec->id)>
                                {{ $tec->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('tecnico_id'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="gestor_id" class="form-label">Gestor asignado</label>
                    <select id="gestor_id"
                            name="gestor_id"
                            class="form-select @error('gestor_id') is-invalid @enderror">
                        <option value="">Sin gestor</option>
                        @foreach ($gestores as $ges)
                            <option value="{{ $ges->id }}" @selected(old('gestor_id', $incidencia->gestor_id) == $ges->id)>
                                {{ $ges->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('gestor_id'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('administrador.incidencias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/incidencias/form.js') }}"></script>
@endpush
