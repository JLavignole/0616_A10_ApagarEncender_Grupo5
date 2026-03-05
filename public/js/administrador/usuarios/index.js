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

    /* ── Botones de desactivar / reactivar usuario ─────── */

    var botonesDesactivar = document.querySelectorAll('.btn-confirmar-desactivar');
    for (var i = 0; i < botonesDesactivar.length; i++) {
        botonesDesactivar[i].onclick = function () {
            var nombre = this.dataset.nombre;
            var formId = this.dataset.form;
            confirmarAccion(
                '¿Desactivar usuario?',
                'El usuario «' + nombre + '» quedará inactivo. Su cuenta quedará inactiva.',
                'warning',
                'Sí, desactivar',
                function () {
                    document.getElementById(formId).submit();
                }
            );
        };
    }

    var botonesReactivar = document.querySelectorAll('.btn-confirmar-reactivar');
    for (var j = 0; j < botonesReactivar.length; j++) {
        botonesReactivar[j].onclick = function () {
            var nombre = this.dataset.nombre;
            var formId = this.dataset.form;
            confirmarAccion(
                '¿Reactivar usuario?',
                'El usuario «' + nombre + '» volverá a estar activo.',
                'question',
                'Sí, reactivar',
                function () {
                    document.getElementById(formId).submit();
                }
            );
        };
    }

};
