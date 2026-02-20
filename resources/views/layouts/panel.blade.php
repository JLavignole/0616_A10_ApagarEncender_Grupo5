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
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
    <script src="{{ asset('js/panel.js') }}" defer></script>
</head>
<body>
    {{-- ═══ Sidebar ═══ --}}
    <aside class="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fa-solid fa-hurricane"></i>
            </div>
            <span class="sidebar-logo-text">TechTrack</span>
        </div>

        {{-- Navegación principal --}}
        <nav class="sidebar-nav">
            <p class="sidebar-section">Principal</p>

            <a href="{{ route('home') }}"
               class="sidebar-link @if(request()->routeIs('home')) active @endif">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Panel de Control</span>
            </a>

            <a href="#"
               class="sidebar-link @if(request()->routeIs('usuarios.*')) active @endif">
                <i class="fa-solid fa-users"></i>
                <span>Gestión de Usuarios</span>
            </a>

            <a href="{{ route('incidencias.index') }}"
               class="sidebar-link @if(request()->routeIs('incidencias.*')) active @endif">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>Incidencias</span>
            </a>

            <p class="sidebar-section">Configuración</p>

            <a href="#"
               class="sidebar-link @if(request()->routeIs('categorias.*')) active @endif">
                <i class="fa-solid fa-tags"></i>
                <span>Tipos y Categorías</span>
            </a>
        </nav>

        {{-- Usuario + Logout (fondo del sidebar) --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ Auth::user()->nombre }}</span>
                    <span class="sidebar-user-role">{{ Auth::user()->rol->nombre ?? 'Usuario' }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout" title="Cerrar sesión">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ Contenido principal ═══ --}}
    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
