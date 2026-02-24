/**
 * CentralIT — Alertas compartidas con SweetAlert2
 *
 * Funciones globales disponibles en toda la aplicación:
 *   toastExito(texto)
 *   toastError(texto)
 *   confirmarAccion(titulo, texto, icono, textoConfirmar, onConfirm)
 *
 * Nota: los scripts se cargan al final del <body>, por lo que
 * el DOM ya está disponible; no se necesita window.onload aquí.
 */

/* ── Toast de éxito ─────────────────────────────────────── */
function toastExito(texto) {
    Swal.fire({
        icon: 'success',
        title: texto || 'Operación realizada correctamente',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

/* ── Toast de error ─────────────────────────────────────── */
function toastError(texto) {
    Swal.fire({
        icon: 'error',
        title: texto || 'Ha ocurrido un error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });
}

/* ── Confirmación de acción ──────────────────────────────── */
function confirmarAccion(titulo, texto, icono, textoConfirmar, onConfirm) {
    Swal.fire({
        title: titulo || '¿Estás seguro?',
        text: texto || 'Esta acción no se puede deshacer.',
        icon: icono || 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: textoConfirmar || 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.isConfirmed && typeof onConfirm === 'function') {
            onConfirm();
        }
    });
}

/* ── Mensajes flash de sesión Laravel ───────────────────── */
(function procesarFlash() {
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
}());
