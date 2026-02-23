/**
 * CentralIT — Alertas compartidas con SweetAlert2
 * Procesa mensajes flash de sesión Laravel
 */
window.onload = function () {
    var flashExito = document.getElementById('flash-exito');
    var flashError = document.getElementById('flash-error');

    if (flashExito) {
        Swal.fire({
            icon: 'success',
            title: 'Operación exitosa',
            text: flashExito.dataset.msg,
            confirmButtonColor: '#2563eb',
            timer: 3500,
            timerProgressBar: true
        });
    }

    if (flashError) {
        Swal.fire({
            icon: 'error',
            title: 'Ha ocurrido un error',
            text: flashError.dataset.msg,
            confirmButtonColor: '#dc2626'
        });
    }
};
