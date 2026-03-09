/* ── Administrador / Sanciones / index.js ───────────────── */

window.onload = function () {
    var formFiltros    = document.getElementById('formFiltros');
    var inputEstado    = document.getElementById('inputEstado');
    var inputBuscar    = document.getElementById('inputBuscar');
    var selectTipo     = document.getElementById('selectTipo');
    var btnTodas       = document.getElementById('btnEstadoTodas');
    var btnActivas     = document.getElementById('btnEstadoActivas');
    var btnFinalizadas = document.getElementById('btnEstadoFinalizadas');
    var contenedor     = document.getElementById('contenedor-tabla');

    if (!formFiltros || !contenedor) return;

    var timerBuscar = null;

    function quitarActivos() {
        if (btnTodas)       { btnTodas.classList.remove('activo'); }
        if (btnActivas)     { btnActivas.classList.remove('activo'); }
        if (btnFinalizadas) { btnFinalizadas.classList.remove('activo'); }
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
            inputEstado.value = 'todas';
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

    if (btnFinalizadas) {
        btnFinalizadas.onclick = function () {
            quitarActivos();
            btnFinalizadas.classList.add('activo');
            inputEstado.value = 'finalizadas';
            aplicarFiltros();
        };
    }

    if (selectTipo) { selectTipo.onchange = aplicarFiltros; }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(aplicarFiltros, 400);
        };
    }

    vincularBotones();

    /* ── Botones de finalizar sanción ──────────────────── */

    function vincularBotones() {
        var botonesFinalizar = document.querySelectorAll('.btn-confirmar-finalizar');
        for (var i = 0; i < botonesFinalizar.length; i++) {
            botonesFinalizar[i].onclick = function () {
                var nombre = this.dataset.nombre;
                var formId = this.dataset.form;
                confirmarAccion(
                    '¿Finalizar sanción?',
                    'La sanción de ' + nombre + ' será finalizada. Esta acción no se puede deshacer.',
                    'warning',
                    'Sí, finalizar',
                    function () {
                        document.getElementById(formId).submit();
                    }
                );
            };
        }
    }

};