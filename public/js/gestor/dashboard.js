/* public/js/gestor/dashboard.js */
window.onload = function () {
    // Confirmación al asignar una incidencia
    var botonesAsignar = document.querySelectorAll('[data-accion="asignar"]');
    for (var i = 0; i < botonesAsignar.length; i++) {
        botonesAsignar[i].onclick = function () {
            var codigo = this.getAttribute('data-codigo') || '—';
            Swal.fire({
                title: 'Asignar incidencia',
                text: '¿Deseas asignar la incidencia ' + codigo + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, asignar',
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
