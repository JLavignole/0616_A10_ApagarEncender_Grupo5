/**
 * CentralIT — Layout (sidebar toggle responsive)
 */
window.onload = function () {
    var toggle  = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
    var main    = document.querySelector('.main-wrapper');

    if (!toggle || !sidebar) return;

    var esMobil = window.innerWidth <= 992;

    toggle.onclick = function () {
        if (esMobil) {
            sidebar.classList.toggle('abierto');
        } else {
            sidebar.classList.toggle('cerrado');
            if (main) main.classList.toggle('expandido');
        }
    };

    window.onresize = function () {
        esMobil = window.innerWidth <= 992;
        if (!esMobil) {
            sidebar.classList.remove('abierto');
        }
    };
};
