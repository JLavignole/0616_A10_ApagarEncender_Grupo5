<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión — TechTrack</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/autenticacion/login.css') }}">
</head>
<body>

    <div class="login-wrapper">

        {{-- ── Columna izquierda: formulario ── --}}
        <div class="login-col-form">
            <div class="login-card">

                <div class="login-header">
                    <h2 class="login-titulo">Bienvenido</h2>
                    <p class="login-subtitulo">Introduce tus credenciales corporativas</p>
                </div>

                <form method="POST" action="{{ route('login') }}" id="formLogin" novalidate>
                    @csrf

                    {{-- Correo --}}
                    <div class="mb-4">
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
                                autofocus
                            >
                        </div>
                        <div class="invalid-feedback d-block" id="error-correo"></div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input
                                type="password"
                                id="contrasena"
                                name="contrasena"
                                class="form-control"
                                placeholder="••••••••"
                                autocomplete="current-password"
                            >
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash" id="iconoPassword"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback d-block" id="error-contrasena"></div>
                    </div>

                    <button
                        type="submit"
                        id="btnLogin"
                        class="btn btn-primary w-100 btn-login"
                        disabled
                    >
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Iniciar sesión
                    </button>

                </form>

                <p class="login-footer-texto">
                    &copy; {{ date('Y') }} TechTrack — Acceso restringido a personal autorizado
                </p>

            </div>
        </div>

        {{-- ── Columna derecha: marca ── --}}
        <div class="login-col-marca d-none d-lg-flex">
            <div class="login-marca-inner">
                <img src="{{ asset('img/logo/logo.png') }}" alt="TechTrack" class="login-marca-logo">
                <h1 class="login-marca-nombre">TechTrack</h1>
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

    {{-- Error de servidor --}}
    @if (session('error'))
        <span id="flash-error" data-msg="{{ session('error') }}" hidden></span>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/autenticacion/login.js') }}"></script>

</body>
</html>
