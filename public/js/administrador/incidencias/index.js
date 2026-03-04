/* ── Administrador / Incidencias / index.js ─────────────── */

window.onload = function () {
    const formFiltros   = document.getElementById('formFiltros');
    const inputBuscar   = document.getElementById('inputBuscar');
    const selectEstado  = document.getElementById('selectEstado');
    const selectPrioridad = document.getElementById('selectPrioridad');
    const selectSede    = document.getElementById('selectSede');
    const selectOrden   = document.getElementById('selectOrden');

    let timerBuscar = null;

    inputBuscar.oninput = function () {
        clearTimeout(timerBuscar);
        timerBuscar = setTimeout(function () {
            formFiltros.submit();
        }, 400);
    };

    selectEstado.onchange = function () {
        formFiltros.submit();
    };

    selectPrioridad.onchange = function () {
        formFiltros.submit();
    };

    selectSede.onchange = function () {
        formFiltros.submit();
    };

    selectOrden.onchange = function () {
        formFiltros.submit();
    };
};
