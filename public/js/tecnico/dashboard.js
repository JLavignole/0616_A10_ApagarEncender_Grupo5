/* public/js/tecnico/dashboard.js */
window.onload = function () {
    // Marcar incidencia como en progreso
    var botonesProgreso = document.querySelectorAll('[data-accion="en-progreso"]');
    for (var i = 0; i < botonesProgreso.length; i++) {
        botonesProgreso[i].onclick = function () {
            var codigo = this.getAttribute('data-codigo') || '—';
            Swal.fire({
                title: 'Cambiar estado',
                text: 'Marcar la incidencia ' + codigo + ' como «En progreso».',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }

    // Marcar incidencia como resuelta
    var botonesResuelta = document.querySelectorAll('[data-accion="resuelta"]');
    for (var j = 0; j < botonesResuelta.length; j++) {
        botonesResuelta[j].onclick = function () {
            var codigo = this.getAttribute('data-codigo') || '—';
            Swal.fire({
                title: '¿Incidencia resuelta?',
                text: 'Marcarás la incidencia ' + codigo + ' como resuelta.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, resuelta',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }
};
