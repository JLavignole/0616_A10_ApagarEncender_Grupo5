/* ── Técnico / Incidencias / detalle.js ─────────────────── */

window.onload = function () {

    /* ── Comenzar trabajo ─────────────────────────────────── */

    var btnComenrzar = document.getElementById('btn-comenzar');

    if (btnComenrzar) {
        btnComenrzar.onclick = function () {
            var codigo = this.getAttribute('data-codigo');

            confirmarAccion(
                '¿Comenzar trabajo?',
                'La incidencia ' + codigo + ' pasará a estado "En progreso".',
                'question',
                'Sí, comenzar',
                function () {
                    document.getElementById('form-comenzar').submit();
                }
            );
        };
    }

    /* ── Resolver incidencia ──────────────────────────────── */

    var btnResolver = document.getElementById('btn-resolver');

    if (btnResolver) {
        btnResolver.onclick = function () {
            var codigo = this.getAttribute('data-codigo');

            confirmarAccion(
                '¿Marcar como resuelta?',
                'La incidencia ' + codigo + ' quedará resuelta y se guardará la fecha y hora actuales.',
                'question',
                'Sí, resolver',
                function () {
                    document.getElementById('form-resolver').submit();
                }
            );
        };
    }

    /* ── Chat: auto-resize textarea ───────────────────────── */

    var textarea = document.getElementById('cuerpo-mensaje');

    if (textarea) {
        textarea.oninput = function () {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        };
    }
};
