/**
 * Filtros AJAX — incidencias del cliente.
 * Promesas con 2 .then(), sin addEventListener.
 */
window.onload = function () {
    var form      = document.getElementById('form-filtros');
    var contenedor = document.getElementById('contenedor-incidencias');
    if (!form || !contenedor) return;

    var actualizarFiltros = function () {
        var formData = new FormData(form);
        var params   = new URLSearchParams(formData).toString();
        var url      = form.action + '?' + params;

        fetch(url)
            .then(function (response) {
                // PRIMER THEN: respuesta a texto (HTML completo)
                return response.text();
            })
            .then(function (html) {
                // SEGUNDO THEN: extraer y volcar el contenedor
                var parser  = new DOMParser();
                var doc     = parser.parseFromString(html, 'text/html');
                var nuevo   = doc.getElementById('contenedor-incidencias').innerHTML;

                contenedor.innerHTML = nuevo;
                window.history.pushState({}, '', url);
            });
    };

    var selectEstado    = document.getElementById('selectEstado');
    var selectPrioridad = document.getElementById('selectPrioridad');
    var selectCategoria = document.getElementById('selectCategoria');
    var inputBuscar     = document.getElementById('inputBuscar');

    if (selectEstado) {
        selectEstado.onchange = function () { actualizarFiltros(); };
    }
    if (selectPrioridad) {
        selectPrioridad.onchange = function () { actualizarFiltros(); };
    }
    if (selectCategoria) {
        selectCategoria.onchange = function () { actualizarFiltros(); };
    }

    if (inputBuscar) {
        var timeout = null;
        inputBuscar.oninput = function () {
            clearTimeout(timeout);
            timeout = setTimeout(actualizarFiltros, 400);
        };
    }
};
