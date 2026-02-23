/* public/js/cliente/dashboard.js */
window.onload = function () {
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
