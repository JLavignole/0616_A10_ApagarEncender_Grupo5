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
        <form method="POST" action="{{ route('administrador.usuarios.update', $usuario) }}" id="formUsuario" novalidate data-edicion="true" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="avatar-seccion mb-4">
                <div class="avatar-actual-wrap">
                    @php
                        $avatarActual = $usuario->perfil && $usuario->perfil->ruta_avatar
                            ? asset('img/perfiles/usuarios/' . $usuario->perfil->ruta_avatar)
                            : asset('img/perfiles/defecto/avatar-default.png');
                    @endphp
                    <img src="{{ $avatarActual }}" alt="Avatar actual" id="previewAvatar" class="avatar-grande">
                </div>
                <div class="avatar-upload-info">
                    <label for="ruta_avatar" class="form-label">Foto de perfil</label>
                    <input type="file"
                           id="ruta_avatar"
                           name="ruta_avatar"
                           class="form-control @error('ruta_avatar') is-invalid @enderror"
                           accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                    <div class="form-text">Formatos: JPG, PNG, GIF, WEBP. Máximo 2 MB. Deja vacío para no cambiar.</div>
                    <div id="error-avatar" class="invalid-feedback d-block">
                        @error('ruta_avatar'){{ $message }}@enderror
                    </div>
                </div>
            </div>

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
