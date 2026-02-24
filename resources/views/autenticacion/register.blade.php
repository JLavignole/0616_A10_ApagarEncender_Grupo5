<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear cuenta — CentralIT</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/autenticacion/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/autenticacion/register.css') }}">
</head>
<body>

    <div class="login-wrapper">

        {{-- ── Columna izquierda: formulario ── --}}
        <div class="login-col-form">
            <div class="login-card">

                <div class="login-header">
                    <h2 class="login-titulo">Crear cuenta</h2>
                    <p class="login-subtitulo">Regístrate para acceder al sistema de incidencias</p>
                </div>

                <form method="POST" action="{{ route('register') }}" id="formRegister" novalidate>
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                class="form-control"
                                value="{{ old('nombre') }}"
                                placeholder="Tu nombre completo"
                                autocomplete="name"
                                autofocus
                            >
                        </div>
                        <div class="invalid-feedback d-block" id="error-nombre"></div>
                    </div>

                    {{-- Correo --}}
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo corporativo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                value="{{ old('correo') }}"
                                placeholder="usuario@empresa.com"
                                autocomplete="email"
                            >
                        </div>
                        <div class="invalid-feedback d-block" id="error-correo"></div>
                    </div>

                    {{-- Sede --}}
                    <div class="mb-3">
                        <label for="sede_id" class="form-label">Sede</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <select id="sede_id" name="sede_id" class="form-select">
                                <option value="">— Seleccionar sede —</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}" @selected(old('sede_id') == $sede->id)>
                                        {{ $sede->nombre }} ({{ $sede->codigo }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="error-sede"></div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input
                                type="password"
                                id="contrasena"
                                name="contrasena"
                                class="form-control"
                                placeholder="Mínimo 8 caracteres"
                                autocomplete="new-password"
                            >
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash" id="iconoPassword"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback d-block" id="error-contrasena"></div>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-4">
                        <label for="contrasena_confirmation" class="form-label">Confirmar contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input
                                type="password"
                                id="contrasena_confirmation"
                                name="contrasena_confirmation"
                                class="form-control"
                                placeholder="Repite la contraseña"
                                autocomplete="new-password"
                            >
                        </div>
                        <div class="invalid-feedback d-block" id="error-confirmacion"></div>
                    </div>

                    <button
                        type="submit"
                        id="btnRegister"
                        class="btn btn-primary w-100 btn-login"
                        disabled
                    >
                        <i class="bi bi-person-plus me-2"></i>
                        Crear cuenta
                    </button>

                </form>

                <div class="login-enlace">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">Inicia sesión</a>
                </div>

                <p class="login-footer-texto">
                    &copy; {{ date('Y') }} CentralIT — Acceso restringido a personal autorizado
                </p>

            </div>
        </div>

        {{-- ── Columna derecha: marca ── --}}
        <div class="login-col-marca d-none d-lg-flex">
            <div class="login-marca-inner">
                <img src="{{ asset('img/logo/logo.png') }}" alt="CentralIT" class="login-marca-logo">
                <h1 class="login-marca-nombre">CentralIT</h1>
                <p class="login-marca-descripcion">
                    Sistema de gestión de incidencias<br>tecnológicas multi-sede
                </p>
                <div class="login-marca-badges">
                    <span class="badge-marca"><i class="bi bi-shield-check"></i> Seguro</span>
                    <span class="badge-marca"><i class="bi bi-building"></i> Multi-sede</span>
                    <span class="badge-marca"><i class="bi bi-people"></i> Multi-rol</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Errores de servidor --}}
    @if ($errors->any())
        <span id="flash-error" data-msg="{{ $errors->first() }}" hidden></span>
    @endif
    @if (session('error'))
        <span id="flash-error" data-msg="{{ session('error') }}" hidden></span>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/autenticacion/register.js') }}"></script>

</body>
</html>
