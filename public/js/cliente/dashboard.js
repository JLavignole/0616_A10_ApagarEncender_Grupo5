/* public/js/cliente/dashboard.js */
window.onload = function () {
    var barraResumen = document.querySelector('.dash-resumen-barra-fill');
    if (barraResumen) {
        var porcentaje = parseInt(barraResumen.getAttribute('data-width') || '0', 10);
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
            Swal.fire({
                title: '¿Cancelar incidencia?',
                text: 'Se cancelará la incidencia ' + codigo + '. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, volver'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }
};
