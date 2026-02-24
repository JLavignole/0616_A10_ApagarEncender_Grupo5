window.onload = function () {

    const formFiltros   = document.getElementById('formFiltros');
    const inputEstado   = document.getElementById('inputEstado');
    const inputBuscar   = document.getElementById('inputBuscar');
    const btnTodas      = document.getElementById('btnEstadoTodas');
    const btnActivas    = document.getElementById('btnEstadoActivas');
    const btnInactivas  = document.getElementById('btnEstadoInactivas');

    let timerBuscar = null;

    if (btnTodas) {
        btnTodas.onclick = function () {
            quitarActivos();
            btnTodas.classList.add('activo');
            inputEstado.value = 'todas';
            formFiltros.submit();
        };
    }

    if (btnActivas) {
        btnActivas.onclick = function () {
            quitarActivos();
            btnActivas.classList.add('activo');
            inputEstado.value = 'activas';
            formFiltros.submit();
        };
    }

    if (btnInactivas) {
        btnInactivas.onclick = function () {
            quitarActivos();
            btnInactivas.classList.add('activo');
            inputEstado.value = 'inactivas';
            formFiltros.submit();
        };
    }

    function quitarActivos() {
        if (btnTodas)     btnTodas.classList.remove('activo');
        if (btnActivas)   btnActivas.classList.remove('activo');
        if (btnInactivas) btnInactivas.classList.remove('activo');
    }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(function () {
                formFiltros.submit();
            }, 400);
        };
    }

};

function confirmarDesactivar(nombre, formId) {
    confirmarAccion(
        'La sede «' + nombre + '» quedará inactiva. Los usuarios de esta sede no podrán registrarse ni crear incidencias.',
        function () {
            document.getElementById(formId).submit();
        }
    );
}

function confirmarActivar(nombre, formId) {
    confirmarAccion(
        '¿Activar la sede «' + nombre + '»?',
        function () {
            document.getElementById(formId).submit();
        }
    );
}
