/* ── Administrador / Categorías / index.js ──────────────── */

window.onload = function () {
    const formFiltros  = document.getElementById('formFiltros');
    const inputEstado  = document.getElementById('inputEstado');
    const inputBuscar  = document.getElementById('inputBuscar');
    const btnTodas     = document.getElementById('btnEstadoTodas');
    const btnActivas   = document.getElementById('btnEstadoActivas');
    const btnInactivas = document.getElementById('btnEstadoInactivas');

    let timerBuscar = null;

    function quitarActivos() {
        btnTodas.classList.remove('active');
        btnActivas.classList.remove('active');
        btnInactivas.classList.remove('active');
    }

    btnTodas.onclick = function () {
        quitarActivos();
        btnTodas.classList.add('active');
        inputEstado.value = '';
        formFiltros.submit();
    };

    btnActivas.onclick = function () {
        quitarActivos();
        btnActivas.classList.add('active');
        inputEstado.value = 'activas';
        formFiltros.submit();
    };

    btnInactivas.onclick = function () {
        quitarActivos();
        btnInactivas.classList.add('active');
        inputEstado.value = 'inactivas';
        formFiltros.submit();
    };

    inputBuscar.oninput = function () {
        clearTimeout(timerBuscar);
        timerBuscar = setTimeout(function () {
            formFiltros.submit();
        }, 400);
    };
};

function confirmarDesactivar(nombre, formId) {
    confirmarAccion(
        '¿Desactivar categoría?',
        'La categoría <strong>' + nombre + '</strong> quedará inactiva.',
        'warning',
        'Sí, desactivar',
        function () {
            document.getElementById(formId).submit();
        }
    );
}

function confirmarActivar(nombre, formId) {
    confirmarAccion(
        '¿Activar categoría?',
        'La categoría <strong>' + nombre + '</strong> volverá a estar activa.',
        'question',
        'Sí, activar',
        function () {
            document.getElementById(formId).submit();
        }
    );
}
