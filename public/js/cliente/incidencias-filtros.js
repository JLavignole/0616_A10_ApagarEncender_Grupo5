/**
 * Lógica de filtros AJAX para la vista de incidencias del cliente
 * Implementación con el sistema de promesas (2 then) y sin addEventListener.
 */

window.onload = function () {
    const form = document.querySelector('.filtros-simple');
    const contenedor = document.getElementById('contenedor-incidencias');
    if (!form || !contenedor) return;

    /**
     * Función principal para actualizar la lista de incidencias vía AJAX
     */
    const actualizarFiltros = function () {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        const url = `${form.action}?${params}`;

        // Sistema de Promesas con 2 .then()
        fetch(url)
            .then(function (response) {
                // PRIMER THEN: Convertimos la respuesta a texto (HTML completo)
                return response.text();
            })
            .then(function (html) {
                // SEGUNDO THEN: Procesamos el HTML y actualizamos solo el contenedor necesario
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const nuevoContenido = doc.getElementById('contenedor-incidencias').innerHTML;

                // Actualizamos el DOM al momento
                contenedor.innerHTML = nuevoContenido;

                // Actualizamos la URL del navegador sin recargar la página
                window.history.pushState({}, '', url);
            });
    };

    // Asignación de eventos manuales (evitando addEventListener)
    const selects = document.querySelectorAll('.auto-submit');
    selects.forEach(function (select) {
        select.onchange = function () {
            actualizarFiltros();
        };
    });

    const inputBuscar = form.querySelector('input[name="buscar"]');
    if (inputBuscar) {
        let timeout = null;
        inputBuscar.oninput = function () {
            // Debounce simple para no saturar con cada tecla
            clearTimeout(timeout);
            timeout = setTimeout(actualizarFiltros, 300);
        };
    }
};
