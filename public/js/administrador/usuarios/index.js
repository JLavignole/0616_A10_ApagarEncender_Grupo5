window.onload = function () {
    var formFiltros    = document.getElementById('formFiltros');
    var inputEstado    = document.getElementById('inputEstado');
    var inputBuscar    = document.getElementById('inputBuscar');
    var selectSede     = document.getElementById('selectSede');
    var selectRol      = document.getElementById('selectRol');
    var btnTodos       = document.getElementById('btnEstadoTodos');
    var btnActivos     = document.getElementById('btnEstadoActivos');
    var btnInactivos   = document.getElementById('btnEstadoInactivos');
    var contenedor     = document.getElementById('contenedor-tabla');

    if (!formFiltros || !contenedor) return;

    var timerBuscar = null;

    function quitarActivos() {
        if (btnTodos)     { btnTodos.classList.remove('activo'); }
        if (btnActivos)   { btnActivos.classList.remove('activo'); }
        if (btnInactivos) { btnInactivos.classList.remove('activo'); }
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

    if (btnTodos) {
        btnTodos.onclick = function () {
            quitarActivos();
            btnTodos.classList.add('activo');
            inputEstado.value = 'todos';
            aplicarFiltros();
        };
    }

    if (btnActivos) {
        btnActivos.onclick = function () {
            quitarActivos();
            btnActivos.classList.add('activo');
            inputEstado.value = 'activos';
            aplicarFiltros();
        };
    }

    if (btnInactivos) {
        btnInactivos.onclick = function () {
            quitarActivos();
            btnInactivos.classList.add('activo');
            inputEstado.value = 'inactivos';
            aplicarFiltros();
        };
    }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(aplicarFiltros, 400);
        };
    }

    if (selectSede) { selectSede.onchange = aplicarFiltros; }
    if (selectRol)  { selectRol.onchange  = aplicarFiltros; }

    vincularBotones();

    function vincularBotones() {
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
    }
};

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
