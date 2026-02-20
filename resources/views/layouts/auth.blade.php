<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InciTech Corporate')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <script src="{{ asset('js/auth.js') }}" defer></script>
</head>
<body>
    {{-- Barra superior --}}
    <nav class="auth-navbar">
        <span class="navbar-brand">@yield('navbar-title', 'Corporate Login')</span>
    </nav>

    {{-- Contenido principal --}}
    <main class="auth-wrapper">
        <div class="auth-card">
            {{-- Logo y encabezado --}}
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h1 class="auth-title">InciTech Corporate</h1>
                <p class="auth-subtitle">Gestión de Incidencias Informáticas</p>
            </div>

            {{-- Mensaje de error general --}}
            @if (session('error'))
                <div class="auth-alert auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        <strong>Error de autenticación</strong>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="auth-alert auth-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong>¡Operación exitosa!</strong>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Contenido del formulario (login o register) --}}
            @yield('content')
        </div>

        {{-- Pie de página --}}
        <footer class="auth-footer">
            &copy; {{ date('Y') }} InciTech Solutions. Acceso restringido a personal autorizado.
        </footer>
    </main>
</body>
</html>
