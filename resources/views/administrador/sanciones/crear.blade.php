@extends('layouts.app')

@section('titulo', 'Nueva Sanción')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/administrador/sanciones/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Nueva Sanción</h2>
            <p class="seccion-subtitulo">Aplica una sanción a un usuario del sistema.</p>
        </div>
        <a href="{{ route('administrador.sanciones.index') }}" class="btn btn-outline-secondary btn-accion">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('administrador.sanciones.store') }}" id="formSancion" novalidate>
            @csrf

            <div class="row g-4">

                {{-- Usuario --}}
                <div class="col-12">
                    <label for="usuario_id" class="form-label">Usuario <span class="texto-requerido">*</span></label>
                    <select id="usuario_id" name="usuario_id"
                            class="form-select @error('usuario_id') is-invalid @enderror">
                        <option value="">— Selecciona un usuario —</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre }} — {{ $usuario->correo }}
                                ({{ $usuario->rol->nombre ?? 'sin rol' }})
                            </option>
                        @endforeach
                    </select>
                    <div id="error-usuario" class="invalid-feedback d-block">
                        @error('usuario_id'){{ $message }}@enderror
                    </div>
                </div>

                {{-- Tipo --}}
                <div class="col-12 col-md-4">
                    <label for="tipo" class="form-label">Tipo de sanción <span class="texto-requerido">*</span></label>
                    <select id="tipo" name="tipo"
                            class="form-select @error('tipo') is-invalid @enderror">
                        <option value="">— Selecciona un tipo —</option>
                        <option value="advertencia" {{ old('tipo') === 'advertencia' ? 'selected' : '' }}>
                            Advertencia
                        </option>
                        <option value="silencio" {{ old('tipo') === 'silencio' ? 'selected' : '' }}>
                            Silencio
                        </option>
                        <option value="bloqueo" {{ old('tipo') === 'bloqueo' ? 'selected' : '' }}>
                            Bloqueo
                        </option>
                    </select>
                    <div id="error-tipo" class="invalid-feedback d-block">
                        @error('tipo'){{ $message }}@enderror
                    </div>
                </div>

                {{-- Fecha inicio --}}
                <div class="col-12 col-md-4">
                    <label for="inicio_en" class="form-label">Fecha de inicio <span class="texto-opcional">(opcional)</span></label>
                    <input type="datetime-local"
                           id="inicio_en"
                           name="inicio_en"
                           class="form-control @error('inicio_en') is-invalid @enderror"
                           value="{{ old('inicio_en') }}">
                    <div id="error-inicio" class="invalid-feedback d-block">
                        @error('inicio_en'){{ $message }}@enderror
                    </div>
                    <div class="form-text">Si se deja vacío, la sanción comienza de inmediato.</div>
                </div>

                {{-- Fecha fin --}}
                <div class="col-12 col-md-4">
                    <label for="fin_en" class="form-label">Fecha de fin <span class="texto-opcional">(opcional)</span></label>
                    <input type="datetime-local"
                           id="fin_en"
                           name="fin_en"
                           class="form-control @error('fin_en') is-invalid @enderror"
                           value="{{ old('fin_en') }}">
                    <div id="error-fin" class="invalid-feedback d-block">
                        @error('fin_en'){{ $message }}@enderror
                    </div>
                    <div class="form-text">Si se deja vacío, la sanción es indefinida.</div>
                </div>

                {{-- Motivo --}}
                <div class="col-12">
                    <label for="motivo" class="form-label">Motivo <span class="texto-requerido">*</span></label>
                    <textarea id="motivo"
                              name="motivo"
                              rows="4"
                              class="form-control @error('motivo') is-invalid @enderror"
                              placeholder="Describe el motivo de la sanción (mínimo 5 caracteres)..."
                              maxlength="1000">{{ old('motivo') }}</textarea>
                    <div id="error-motivo" class="invalid-feedback d-block">
                        @error('motivo'){{ $message }}@enderror
                    </div>
                </div>

                {{-- Aviso bloqueo --}}
                <div class="col-12" id="avisoBan" style="display:none;">
                    <div class="aviso-bloqueo">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Bloqueo:</strong> El usuario no podrá iniciar sesión mientras la sanción esté activa.
                    </div>
                </div>

            </div>

            <div class="form-footer">
                <a href="{{ route('administrador.sanciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" id="btnGuardar" class="btn btn-danger">
                    <i class="bi bi-shield-exclamation me-1"></i> Aplicar sanción
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/administrador/sanciones/form.js') }}"></script>
@endpush
