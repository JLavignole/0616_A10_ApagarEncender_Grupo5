/* ── Técnico / Incidencias / index.js ───────────────────── */

window.onload = function () {
    var formFiltros     = document.getElementById('formFiltros');
    var inputBuscar     = document.getElementById('inputBuscar');
    var selectEstado    = document.getElementById('selectEstado');
    var selectPrioridad = document.getElementById('selectPrioridad');
    var selectCategoria = document.getElementById('selectCategoria');
    var selectOrden     = document.getElementById('selectOrden');

    var timerBuscar = null;

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(function () {
                formFiltros.submit();
            }, 400);
        };
    }

    if (selectEstado) {
        selectEstado.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectPrioridad) {
        selectPrioridad.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectCategoria) {
        selectCategoria.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectOrden) {
        selectOrden.onchange = function () {
            formFiltros.submit();
        };
    }

    /* ── Confirmación de acciones de estado ──────────────── */

    var botonesAccion = document.querySelectorAll('.btn-accion-estado');

    for (var i = 0; i < botonesAccion.length; i++) {
        botonesAccion[i].onclick = function () {
            var formId = this.getAttribute('data-form');
            var codigo = this.getAttribute('data-codigo');
            var accion = this.getAttribute('data-accion');

            if (accion === 'comenzar') {
                confirmarAccion(
                    '¿Comenzar trabajo?',
                    'La incidencia ' + codigo + ' pasará a estado "En progreso".',
                    'question',
                    'Sí, comenzar',
                    function () {
                        document.getElementById(formId).submit();
                    }
                );
            } else if (accion === 'resolver') {
                confirmarAccion(
                    '¿Marcar como resuelta?',
                    'La incidencia ' + codigo + ' quedará marcada como resuelta y se guardará la fecha y hora actuales.',
                    'question',
                    'Sí, resolver',
                    function () {
                        document.getElementById(formId).submit();
                    }
                );
            }
        };
    }
};
