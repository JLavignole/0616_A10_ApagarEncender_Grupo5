@extends('layouts.app')

@section('titulo', 'Mi perfil')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/perfil/form.css') }}">
@endpush

@section('contenido')

    <div class="seccion-header">
        <div>
            <h2 class="seccion-titulo">Mi perfil</h2>
            <p class="seccion-subtitulo">Gestiona tu información personal y contraseña</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('perfil.update') }}" id="formPerfil" novalidate enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ── Avatar ── --}}
            <div class="avatar-seccion mb-4">
                <div class="avatar-actual-wrap">
                    @php
                        $avatarActual = $usuario->perfil && $usuario->perfil->ruta_avatar
                            ? asset('img/perfiles/usuarios/' . $usuario->perfil->ruta_avatar)
                            : asset('img/perfiles/defecto/avatar-default.png');
                    @endphp
                    <img src="{{ $avatarActual }}" alt="Avatar" id="previewAvatar" class="avatar-grande">
                </div>
                <div class="avatar-upload-info">
                    <label for="ruta_avatar" class="form-label">Foto de perfil</label>
                    <input type="file"
                           id="ruta_avatar"
                           name="ruta_avatar"
                           class="form-control @error('ruta_avatar') is-invalid @enderror"
                           accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                    <div class="form-text">Formatos: JPG, PNG, GIF, WEBP. Máximo 2 MB. Deja vacío para no cambiar.</div>
                    <div id="error-avatar" class="invalid-feedback d-block">
                        @error('ruta_avatar'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- ── Datos de cuenta ── --}}
            <div class="perfil-seccion-titulo">
                <i class="bi bi-person-lock me-2"></i>Datos de cuenta
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre <span class="texto-requerido">*</span></label>
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $usuario->nombre) }}"
                           placeholder="Tu nombre completo"
                           maxlength="255"
                           autocomplete="off">
                    <div id="error-nombre" class="invalid-feedback d-block">
                        @error('nombre'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo electrónico <span class="texto-requerido">*</span></label>
                    <input type="text"
                           id="correo"
                           name="correo"
                           class="form-control @error('correo') is-invalid @enderror"
                           value="{{ old('correo', $usuario->correo) }}"
                           placeholder="correo@ejemplo.com"
                           maxlength="255"
                           autocomplete="off">
                    <div id="error-correo" class="invalid-feedback d-block">
                        @error('correo'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password"
                           id="contrasena"
                           name="contrasena"
                           class="form-control @error('contrasena') is-invalid @enderror"
                           placeholder="Dejar vacío para no cambiar"
                           autocomplete="new-password">
                    <div id="error-contrasena" class="invalid-feedback d-block">
                        @error('contrasena'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- ── Información personal ── --}}
            <div class="perfil-seccion-titulo">
                <i class="bi bi-info-circle me-2"></i>Información personal
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text"
                           id="apellidos"
                           name="apellidos"
                           class="form-control @error('apellidos') is-invalid @enderror"
                           value="{{ old('apellidos', $usuario->perfil?->apellidos) }}"
                           placeholder="Tus apellidos"
                           maxlength="255"
                           autocomplete="off">
                    <div id="error-apellidos" class="invalid-feedback d-block">
                        @error('apellidos'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text"
                           id="telefono"
                           name="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $usuario->perfil?->telefono) }}"
                           placeholder="+34 600 000 000"
                           maxlength="50"
                           autocomplete="off">
                    <div id="error-telefono" class="invalid-feedback d-block">
                        @error('telefono'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text"
                           id="cargo"
                           name="cargo"
                           class="form-control @error('cargo') is-invalid @enderror"
                           value="{{ old('cargo', $usuario->perfil?->cargo) }}"
                           placeholder="Tu cargo en la empresa"
                           maxlength="100"
                           autocomplete="off">
                    <div id="error-cargo" class="invalid-feedback d-block">
                        @error('cargo'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="departamento" class="form-label">Departamento</label>
                    <input type="text"
                           id="departamento"
                           name="departamento"
                           class="form-control @error('departamento') is-invalid @enderror"
                           value="{{ old('departamento', $usuario->perfil?->departamento) }}"
                           placeholder="Tu departamento"
                           maxlength="100"
                           autocomplete="off">
                    <div id="error-departamento" class="invalid-feedback d-block">
                        @error('departamento'){{ $message }}@enderror
                    </div>
                </div>

                <div class="col-12">
                    <label for="biografia" class="form-label">Biografía</label>
                    <textarea id="biografia"
                              name="biografia"
                              class="form-control @error('biografia') is-invalid @enderror"
                              rows="3"
                              placeholder="Cuéntanos un poco sobre ti..."
                              maxlength="1000">{{ old('biografia', $usuario->perfil?->biografia) }}</textarea>
                    <div class="d-flex justify-content-between">
                        <div id="error-biografia" class="invalid-feedback d-block">
                            @error('biografia'){{ $message }}@enderror
                        </div>
                        <small id="contadorBiografia" class="text-muted ms-auto">
                            {{ strlen(old('biografia', $usuario->perfil?->biografia ?? '')) }}/1000
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" id="btnGuardar" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/perfil/form.js') }}"></script>
@endpush
