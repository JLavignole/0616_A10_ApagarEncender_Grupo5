/* ── Administrador / Sanciones / index.js ────────────────── *//* ── Administrador / Sanciones / index.js ───────────────── */




























































}    );        }            document.getElementById(formId).submit();        function () {        '¿Finalizar la sanción de ' + nombre + '? Esta acción no se puede deshacer.',    confirmarAccion(function confirmarFinalizar(nombre, formId) {};    };        }, 400);            formFiltros.submit();        timerBuscar = setTimeout(function () {        clearTimeout(timerBuscar);    inputBuscar.oninput = function () {    };        formFiltros.submit();    selectTipo.onchange = function () {    };        formFiltros.submit();        inputEstado.value = 'finalizadas';        btnFinalizadas.classList.add('activo');        quitarActivos();    btnFinalizadas.onclick = function () {    };        formFiltros.submit();        inputEstado.value = 'activas';        btnActivas.classList.add('activo');        quitarActivos();    btnActivas.onclick = function () {    };        formFiltros.submit();        inputEstado.value = 'todas';        btnTodas.classList.add('activo');        quitarActivos();    btnTodas.onclick = function () {    }        btnFinalizadas.classList.remove('activo');        btnActivas.classList.remove('activo');        btnTodas.classList.remove('activo');    function quitarActivos() {    let timerBuscar = null;    const btnFinalizadas     = document.getElementById('btnEstadoFinalizadas');    const btnActivas         = document.getElementById('btnEstadoActivas');    const btnTodas           = document.getElementById('btnEstadoTodas');    const selectTipo         = document.getElementById('selectTipo');    const inputBuscar        = document.getElementById('inputBuscar');    const inputEstado        = document.getElementById('inputEstado');    const formFiltros        = document.getElementById('formFiltros');window.onload = function () {
window.onload = function () {
    const formFiltros        = document.getElementById('formFiltros');
    const inputEstado        = document.getElementById('inputEstado');
    const inputBuscar        = document.getElementById('inputBuscar');
    const selectTipo         = document.getElementById('selectTipo');
    const btnTodas           = document.getElementById('btnEstadoTodas');
    const btnActivas         = document.getElementById('btnEstadoActivas');
    const btnFinalizadas     = document.getElementById('btnEstadoFinalizadas');

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
        'Se dará por finalizada la sanción de ' + nombre + '. Esta acción no se puede deshacer.',
        function () {
            document.getElementById(formId).submit();
        }
    );
}
