window.onload = function () {

    const formFiltros    = document.getElementById('formFiltros');
    const inputEstado    = document.getElementById('inputEstado');
    const inputBuscar    = document.getElementById('inputBuscar');
    const selectSede     = document.getElementById('selectSede');
    const selectRol      = document.getElementById('selectRol');
    const btnTodos       = document.getElementById('btnEstadoTodos');
    const btnActivos     = document.getElementById('btnEstadoActivos');
    const btnInactivos   = document.getElementById('btnEstadoInactivos');

    let timerBuscar = null;

    if (btnTodos) {
        btnTodos.onclick = function () {
            quitarActivos();
            btnTodos.classList.add('activo');
            inputEstado.value = 'todos';
            formFiltros.submit();
        };
    }

    if (btnActivos) {
        btnActivos.onclick = function () {
            quitarActivos();
            btnActivos.classList.add('activo');
            inputEstado.value = 'activos';
            formFiltros.submit();
        };
    }

    if (btnInactivos) {
        btnInactivos.onclick = function () {
            quitarActivos();
            btnInactivos.classList.add('activo');
            inputEstado.value = 'inactivos';
            formFiltros.submit();
        };
    }

    function quitarActivos() {
        if (btnTodos)     btnTodos.classList.remove('activo');
        if (btnActivos)   btnActivos.classList.remove('activo');
        if (btnInactivos) btnInactivos.classList.remove('activo');
    }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(function () {
                formFiltros.submit();
            }, 400);
        };
    }

    if (selectSede) {
        selectSede.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectRol) {
        selectRol.onchange = function () {
            formFiltros.submit();
        };
    }

};

function confirmarDesactivar(nombre, formId) {
    confirmarAccion(
        '¿Desactivar al usuario «' + nombre + '»? Su cuenta quedará inactiva.',
        function () {
            document.getElementById(formId).submit();
        }
    );
}

function confirmarReactivar(nombre, formId) {
    confirmarAccion(
        '¿Reactivar al usuario «' + nombre + '»?',
        function () {
            document.getElementById(formId).submit();
        }
    );
}
