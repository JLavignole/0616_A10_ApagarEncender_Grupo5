/* public/js/gestor/tecnicos.js */

window.onload = function () {
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
};
