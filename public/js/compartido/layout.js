/**
 * CentralIT — Layout (sidebar toggle responsive)
 * El script se carga al final del body, el DOM está disponible directamente.
 */
var toggle  = document.getElementById('sidebarToggle');
var sidebar = document.getElementById('sidebar');
var overlay = document.getElementById('sidebarOverlay');
var main    = document.querySelector('.main-wrapper');

if (toggle && sidebar) {
    var esMobil = window.innerWidth <= 992;

    function cerrarSidebar() {
        sidebar.classList.remove('abierto');
        if (overlay) overlay.classList.remove('activo');
    }

    toggle.onclick = function () {
        if (esMobil) {
            sidebar.classList.toggle('abierto');
            if (overlay) overlay.classList.toggle('activo');
        } else {
            sidebar.classList.toggle('cerrado');
            if (main) main.classList.toggle('expandido');
        }
    };

    if (overlay) {
        overlay.onclick = cerrarSidebar;
    }

    window.onresize = function () {
        esMobil = window.innerWidth <= 992;
        if (!esMobil) {
            cerrarSidebar();
        }
    };
}
