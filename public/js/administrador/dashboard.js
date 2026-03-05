/* public/js/administrador/dashboard.js */
window.onload = function () {

    /* ── Filtros de incidencias ──────────────────────────── */
    var formFiltros    = document.getElementById('formFiltros');
    var inputBuscar    = document.getElementById('inputBuscar');
    var selectEstado   = document.getElementById('selectEstado');
    var selectPrioridad = document.getElementById('selectPrioridad');
    var selectSede     = document.getElementById('selectSede');
    var selectCategoria = document.getElementById('selectCategoria');
    var inputFecha     = document.getElementById('inputFecha');

    var timerBuscar = null;

    // Si hay un texto en el input de búsqueda, esperar a que el usuario deje de escribir para enviar el formulario
    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(function () {
                formFiltros.submit();
            }, 400);
        };
    }
    // Para los selects, enviar el formulario inmediatamente al cambiar la selección
    if (selectEstado) {
        selectEstado.onchange = function () {
            formFiltros.submit();
        };
    }
    // Lo mismo para prioridad, sede, categoría y fecha
    if (selectPrioridad) {
        selectPrioridad.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectSede) {
        selectSede.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectCategoria) {
        selectCategoria.onchange = function () {
            formFiltros.submit();
        };
    }

    if (inputFecha) {
        inputFecha.onchange = function () {
            formFiltros.submit();
        };
    }

    /* ── Botones de eliminar (genérico) ─────────────────── */
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
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }
};
