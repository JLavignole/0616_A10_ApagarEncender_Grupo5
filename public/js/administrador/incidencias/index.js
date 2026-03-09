/* ── Administrador / Incidencias / index.js ─────────────── */

window.onload = function () {
    var formFiltros     = document.getElementById('formFiltros');
    var inputBuscar     = document.getElementById('inputBuscar');
    var selectEstado    = document.getElementById('selectEstado');
    var selectPrioridad = document.getElementById('selectPrioridad');
    var selectSede      = document.getElementById('selectSede');
    var selectOrden     = document.getElementById('selectOrden');
    var contenedor      = document.getElementById('contenedor-tabla');

    if (!formFiltros || !contenedor) return;

    var timerBuscar = null;

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
            });
    }

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(aplicarFiltros, 400);
        };
    }

    if (selectEstado)    { selectEstado.onchange    = aplicarFiltros; }
    if (selectPrioridad) { selectPrioridad.onchange = aplicarFiltros; }
    if (selectSede)      { selectSede.onchange      = aplicarFiltros; }
    if (selectOrden)     { selectOrden.onchange     = aplicarFiltros; }
};
