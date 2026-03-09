/**
 * CentralIT — Layout (sidebar toggle responsive)
 * Usa addEventListener para no colisionar con window.onload de las páginas hijas.
 */
document.addEventListener('DOMContentLoaded', function () {
    var toggle  = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var main    = document.querySelector('.main-wrapper');

    if (!toggle || !sidebar) return;

    var esMobil = window.innerWidth <= 992;

    function cerrarSidebar() {
        sidebar.classList.remove('abierto');
        if (overlay) overlay.classList.remove('activo');
    }

    toggle.addEventListener('click', function () {
        if (esMobil) {
            sidebar.classList.toggle('abierto');
            if (overlay) overlay.classList.toggle('activo');
        } else {
            sidebar.classList.toggle('cerrado');
            if (main) main.classList.toggle('expandido');
        }
    });

    if (overlay) {
        overlay.addEventListener('click', cerrarSidebar);
    }

    window.addEventListener('resize', function () {
        esMobil = window.innerWidth <= 992;
        if (!esMobil) {
            cerrarSidebar();
        }
    });
});
