/* public/js/cliente/dashboard.js */
window.onload = function () {
    // Ancho de la barra de progreso desde data-pct
    var barraResumen = document.querySelector('.dash-resumen-barra-fill');
    if (barraResumen) {
        var porcentaje = parseInt(barraResumen.getAttribute('data-pct') || '0', 10);
        if (isNaN(porcentaje)) {
            porcentaje = 0;
        }

        if (porcentaje < 0) {
            porcentaje = 0;
        }

        if (porcentaje > 100) {
            porcentaje = 100;
        }

        barraResumen.style.width = porcentaje + '%';
    }

    // Confirmación antes de cancelar una incidencia propia
    var botonesCancelar = document.querySelectorAll('[data-accion="cancelar"]');
    for (var i = 0; i < botonesCancelar.length; i++) {
        botonesCancelar[i].onclick = function () {
            var codigo = this.getAttribute('data-codigo') || '—';
            var url    = this.getAttribute('data-url');
            confirmarAccion(
                '¿Cancelar incidencia?',
                'Se cancelará la incidencia ' + codigo + '. Esta acción no se puede deshacer.',
                'warning',
                'Sí, cancelar',
                function () {
                    if (url) window.location.href = url;
                }
            );
        };
    }
};
