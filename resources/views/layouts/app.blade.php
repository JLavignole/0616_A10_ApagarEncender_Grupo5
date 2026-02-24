<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'TechTrack') — TechTrack</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/compartido/layout.css') }}">

    @stack('estilos')
</head>
<body>
    @php
        /** @var \App\Models\User $usuario */
        $usuario      = Auth::user();
        $rolNombre    = $usuario->rol->nombre ?? 'cliente';
        $avatarSrc    = $usuario->perfil?->ruta_avatar
                          ? asset('img/perfiles/usuarios/' . $usuario->perfil->ruta_avatar)
                          : asset('img/perfiles/defecto/avatar-default.png');
        $rutaActual   = request()->path();
    @endphp

    <div class="layout-wrapper" id="layoutWrapper">

        {{-- ═══════════ SIDEBAR ═══════════ --}}
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-logo">
                <img src="{{ asset('img/logo/logo.png') }}" alt="TechTrack" class="sidebar-logo-img">
                <span class="sidebar-logo-text">TechTrack</span>
            </div>

            <nav class="sidebar-nav">

                {{-- ── Administrador ── --}}
                @if (in_array($rolNombre, ['admin', 'administrador']))
                    <p class="sidebar-section">Principal</p>

                    <a href="{{ route('administrador.dashboard') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <p class="sidebar-section">Gestión</p>

                    <a href="{{ route('administrador.usuarios.index') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/usuarios') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Usuarios</span>
                    </a>
                    <a href="{{ route('administrador.categorias.index') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/categorias') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Categorías</span>
                    </a>
                    <a href="{{ route('administrador.subcategorias.index') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/subcategorias') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3"></i>
                        <span>Subcategorías</span>
                    </a>
                    <a href="{{ route('administrador.sedes.index') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/sedes') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Sedes</span>
                    </a>
                    <a href="{{ route('administrador.sanciones.index') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'administrador/sanciones') ? 'active' : '' }}">
                        <i class="bi bi-shield-exclamation"></i>
                        <span>Sanciones</span>
                    </a>

                {{-- ── Gestor ── --}}
                @elseif ($rolNombre === 'gestor')
                    <p class="sidebar-section">Principal</p>

                    <a href="{{ route('gestor.dashboard') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'gestor/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <p class="sidebar-section">Gestión</p>

                    <a href="#" class="sidebar-link">
                        <i class="bi bi-clipboard-list"></i>
                        <span>Incidencias</span>
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-bar-chart-line"></i>
                        <span>Carga técnicos</span>
                    </a>

                {{-- ── Técnico ── --}}
                @elseif ($rolNombre === 'tecnico')
                    <p class="sidebar-section">Principal</p>

                    <a href="{{ route('tecnico.dashboard') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'tecnico/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <p class="sidebar-section">Trabajo</p>

                    <a href="#" class="sidebar-link">
                        <i class="bi bi-tools"></i>
                        <span>Mis incidencias</span>
                    </a>

                {{-- ── Cliente ── --}}
                @else
                    <p class="sidebar-section">Principal</p>

                    <a href="{{ route('cliente.dashboard') }}"
                       class="sidebar-link {{ str_starts_with($rutaActual, 'cliente/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <p class="sidebar-section">Incidencias</p>

                    <a href="#" class="sidebar-link">
                        <i class="bi bi-list-check"></i>
                        <span>Mis incidencias</span>
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-plus-circle"></i>
                        <span>Crear incidencia</span>
                    </a>
                @endif

                {{-- ── Común ── --}}
                <p class="sidebar-section">Mi cuenta</p>

                <a href="{{ route('perfil.show') }}"
                   class="sidebar-link {{ str_starts_with($rutaActual, 'perfil') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Mi perfil</span>
                </a>

            </nav>

            <div class="sidebar-footer">
                <img src="{{ $avatarSrc }}" alt="{{ $usuario->nombre }}" class="sidebar-footer-avatar">
                <div class="sidebar-footer-info">
                    <span class="sidebar-footer-nombre">{{ $usuario->nombre }}</span>
                    <span class="sidebar-footer-rol">{{ ucfirst($rolNombre) }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ═══════════ ÁREA PRINCIPAL ═══════════ --}}
        <div class="main-wrapper">

            <header class="topbar">
                <div class="topbar-izquierda">
                    <button class="topbar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="topbar-titulo">@yield('titulo', 'Dashboard')</h1>
                </div>
                <div class="topbar-derecha">
                    <span class="topbar-sede">
                        <i class="bi bi-geo-alt"></i>
                        {{ $usuario->sede->nombre ?? '—' }}
                    </span>
                    <div class="topbar-usuario">
                        <img src="{{ $avatarSrc }}" alt="{{ $usuario->nombre }}" class="topbar-avatar">
                        <span class="topbar-nombre d-none d-lg-inline">{{ $usuario->nombre }}</span>
                    </div>
                </div>
            </header>

            <main class="contenido-pagina">
                @yield('contenido')
            </main>

        </div>
    </div>

    {{-- Mensajes flash --}}
    @if (session('exito'))
        <span id="flash-exito" data-msg="{{ session('exito') }}" hidden></span>
    @endif
    @if (session('error'))
        <span id="flash-error" data-msg="{{ session('error') }}" hidden></span>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/compartido/alertas.js') }}"></script>
    <script src="{{ asset('js/compartido/layout.js') }}"></script>

    @stack('scripts')
</body>
</html>
