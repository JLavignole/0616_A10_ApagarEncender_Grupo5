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
};

function confirmarFinalizar(nombre, formId) {
    confirmarAccion(
        '¿Finalizar la sanción de ' + nombre + '? Esta acción no se puede deshacer.',
        function () {
            document.getElementById(formId).submit();
        }
    );
}