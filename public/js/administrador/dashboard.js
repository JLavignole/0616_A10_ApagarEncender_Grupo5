/* public/js/administrador/dashboard.js */
window.onload = function () {
    // Confirmación antes de realizar acciones destructivas en la tabla
    var botonesEliminar = document.querySelectorAll('[data-accion="eliminar"]');
    for (var i = 0; i < botonesEliminar.length; i++) {
        botonesEliminar[i].onclick = function () {
            var nombre = this.getAttribute('data-nombre') || 'este elemento';
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se eliminará «' + nombre + '». Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    // redirigir a la ruta de eliminación
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }
};
