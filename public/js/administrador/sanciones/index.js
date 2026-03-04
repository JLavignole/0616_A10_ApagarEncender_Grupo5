/* ── Administrador / Sanciones / index.js ───────────────── */

window.onload = function () {
    const formFiltros    = document.getElementById('formFiltros');
    const inputEstado    = document.getElementById('inputEstado');
    const inputBuscar    = document.getElementById('inputBuscar');
    const selectTipo     = document.getElementById('selectTipo');
    const btnTodas       = document.getElementById('btnEstadoTodas');
    const btnActivas     = document.getElementById('btnEstadoActivas');
    const btnFinalizadas = document.getElementById('btnEstadoFinalizadas');

    let timerBuscar = null;

    function quitarActivos() {
        btnTodas.classList.remove('activo');
        btnActivas.classList.remove('activo');
        btnFinalizadas.classList.remove('activo');
    }

    btnTodas.onclick = function () {
        quitarActivos();
        btnTodas.classList.add('activo');
        inputEstado.value = 'todas';
        formFiltros.submit();
    };

    btnActivas.onclick = function () {
        quitarActivos();
        btnActivas.classList.add('activo');
        inputEstado.value = 'activas';
        formFiltros.submit();
    };

    btnFinalizadas.onclick = function () {
        quitarActivos();
        btnFinalizadas.classList.add('activo');
        inputEstado.value = 'finalizadas';
        formFiltros.submit();
    };

    selectTipo.onchange = function () {
        formFiltros.submit();
    };

    inputBuscar.oninput = function () {
        clearTimeout(timerBuscar);
        timerBuscar = setTimeout(function () {
            formFiltros.submit();
        }, 400);
    };

    /* ── Botones de finalizar sanción ──────────────────── */

    var botonesFinalizar = document.querySelectorAll('.btn-confirmar-finalizar');
    for (var i = 0; i < botonesFinalizar.length; i++) {
        botonesFinalizar[i].onclick = function () {
            var nombre = this.dataset.nombre;
            var formId = this.dataset.form;
            confirmarAccion(
                '¿Finalizar sanción?',
                'La sanción de ' + nombre + ' será finalizada. Esta acción no se puede deshacer.',
                'warning',
                'Sí, finalizar',
                function () {
                    document.getElementById(formId).submit();
                }
            );
        };
    }

};