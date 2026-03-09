/* ── Administrador / Categorías / index.js ──────────────── */

window.onload = function () {
    var formFiltros  = document.getElementById('formFiltros');
    var inputEstado  = document.getElementById('inputEstado');
    var inputBuscar  = document.getElementById('inputBuscar');
    var btnTodas     = document.getElementById('btnEstadoTodas');
    var btnActivas   = document.getElementById('btnEstadoActivas');
    var btnInactivas = document.getElementById('btnEstadoInactivas');
    var contenedor   = document.getElementById('contenedor-tabla');

    if (!formFiltros || !contenedor) return;

    var timerBuscar = null;

    function quitarActivos() {
        if (btnTodas)     { btnTodas.classList.remove('activo'); }
        if (btnActivas)   { btnActivas.classList.remove('activo'); }
        if (btnInactivas) { btnInactivas.classList.remove('activo'); }
    }

    function aplicarFiltros() {
        var params = new URLSearchParams(new FormData(formFiltros)).toString();
        var url = formFiltros.action + '?' + params;

        fetch(url)
            .then(function (respuesta) {
                return respuesta.text();
            })
            .then(function (html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                contenedor.innerHTML = doc.getElementById('contenedor-tabla').innerHTML;
                window.history.pushState({}, '', url);
                vincularBotones();
            });
    }

    if (btnTodas) {
        btnTodas.onclick = function () {
            quitarActivos();
            btnTodas.classList.add('activo');
            inputEstado.value = '';
            aplicarFiltros();
        };
    }

    if (btnActivas) {
        btnActivas.onclick = function () {
            quitarActivos();
            btnActivas.classList.add('activo');
            inputEstado.value = 'activas';
            aplicarFiltros();
        };
    }

    if (btnInactivas) {
        btnInactivas.onclick = function () {
            quitarActivos();
            btnInactivas.classList.add('activo');
            inputEstado.value = 'inactivas';
            aplicarFiltros();
        };
    }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(aplicarFiltros, 400);
        };
    }

    vincularBotones();

    /* ── Botones de desactivar / activar categoría ─────── */

    function vincularBotones() {
        var botonesDesactivar = document.querySelectorAll('.btn-confirmar-desactivar');
        for (var i = 0; i < botonesDesactivar.length; i++) {
            botonesDesactivar[i].onclick = function () {
                var nombre = this.dataset.nombre;
                var formId = this.dataset.form;
                confirmarAccion(
                    '¿Desactivar categoría?',
                    'La categoría <strong>' + nombre + '</strong> quedará inactiva.',
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
                    '¿Activar categoría?',
                    'La categoría <strong>' + nombre + '</strong> volverá a estar activa.',
                    'question',
                    'Sí, activar',
                    function () {
                        document.getElementById(formId).submit();
                    }
                );
            };
        }
    }

};
