/* public/js/gestor/tecnicos.js */

/**
 * Gestor Carga de Técnicos — Toggle desplegar/colapsar lista de incidencias
 */

var cabeceras = document.querySelectorAll('[data-toggle="tecnico"]');

for (var i = 0; i < cabeceras.length; i++) {
    cabeceras[i].onclick = function () {
        var card = this.closest('.tecnico-card');
        var lista = card.querySelector('.tecnico-lista');

        if (lista.hasAttribute('hidden')) {
            lista.removeAttribute('hidden');
            this.classList.add('abierto');
        } else {
            lista.setAttribute('hidden', '');
            this.classList.remove('abierto');
        }
    };
}
