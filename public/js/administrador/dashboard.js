/* public/js/administrador/dashboard.js */
window.onload = function () {

    /* ── Filtros de incidencias ──────────────────────────── */
    var formFiltros    = document.getElementById('formFiltros');
    var inputBuscar    = document.getElementById('inputBuscar');
    var selectEstado   = document.getElementById('selectEstado');
    var selectPrioridad = document.getElementById('selectPrioridad');
    var selectSede     = document.getElementById('selectSede');
    var inputFecha     = document.getElementById('inputFecha');

    var contenedor = document.getElementById('contenedor-tabla');
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
                if (contenedor && doc.getElementById('contenedor-tabla')) {
                    contenedor.innerHTML = doc.getElementById('contenedor-tabla').innerHTML;
                }
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
    if (inputFecha)      { inputFecha.onchange      = aplicarFiltros; }

    /* ── Botones de eliminar (genérico) ─────────────────── */
    var botonesEliminar = document.querySelectorAll('[data-accion="eliminar"]');
    for (var i = 0; i < botonesEliminar.length; i++) {
        botonesEliminar[i].onclick = function () {
            var nombre = this.getAttribute('data-nombre') || 'este elemento';
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se eliminará «' + nombre + '». Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    var url = this.getAttribute('data-url');
                    if (url) window.location.href = url;
                }
            }.bind(this));
        };
    }
};
