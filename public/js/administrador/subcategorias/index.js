/* ── Administrador / Subcategorías / index.js ───────────── */

window.onload = function () {
    const formFiltros      = document.getElementById('formFiltros');
    const inputEstado      = document.getElementById('inputEstado');
    const inputBuscar      = document.getElementById('inputBuscar');
    const selectCategoria  = document.getElementById('selectCategoria');
    const btnTodas         = document.getElementById('btnEstadoTodas');
    const btnActivas       = document.getElementById('btnEstadoActivas');
    const btnInactivas     = document.getElementById('btnEstadoInactivas');

    let timerBuscar = null;

    function quitarActivos() {
        btnTodas.classList.remove('activo');
        btnActivas.classList.remove('activo');
        btnInactivas.classList.remove('activo');
    }

    btnTodas.onclick = function () {
        quitarActivos();
        btnTodas.classList.add('activo');
        inputEstado.value = '';
        formFiltros.submit();
    };

    btnActivas.onclick = function () {
        quitarActivos();
        btnActivas.classList.add('activo');
        inputEstado.value = 'activas';
        formFiltros.submit();
    };

    btnInactivas.onclick = function () {
        quitarActivos();
        btnInactivas.classList.add('activo');
        inputEstado.value = 'inactivas';
        formFiltros.submit();
    };

    selectCategoria.onchange = function () {
        formFiltros.submit();
    };

    inputBuscar.oninput = function () {
        clearTimeout(timerBuscar);
        timerBuscar = setTimeout(function () {
            formFiltros.submit();
        }, 400);
    };

    /* ── Botones de desactivar / activar subcategoría ──── */

    var botonesDesactivar = document.querySelectorAll('.btn-confirmar-desactivar');
    for (var i = 0; i < botonesDesactivar.length; i++) {
        botonesDesactivar[i].onclick = function () {
            var nombre = this.dataset.nombre;
            var formId = this.dataset.form;
            confirmarAccion(
                '¿Desactivar subcategoría?',
                'La subcategoría <strong>' + nombre + '</strong> quedará inactiva.',
                'warning',
                'Sí, desactivar',
                function () {
                    document.getElementById(formId).submit();
                }
            );
        };
    }

    var botonesActivar = document.querySelectorAll('.btn-confirmar-activar');
    for (var j = 0; j < botonesActivar.length; j++) {
        botonesActivar[j].onclick = function () {
            var nombre = this.dataset.nombre;
            var formId = this.dataset.form;
            confirmarAccion(
                '¿Activar subcategoría?',
                'La subcategoría <strong>' + nombre + '</strong> volverá a estar activa.',
                'question',
                'Sí, activar',
                function () {
                    document.getElementById(formId).submit();
                }
            );
        };
    }

};
