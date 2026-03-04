
let instanciaModal;

window.onload = function() {
    // Inicializar el modal de Bootstrap 5
    const el = document.getElementById('modalResolver');
    if (el) instanciaModal = new bootstrap.Modal(el);

    // Validación visual onblur (Regla 4)
    const area = document.getElementById('comentario_resolucion');
    if (area) {
        area.onblur = function() {
            if (this.value.length < 10) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        };
    }
};

function confirmarComienzo(id) {
    CentralAlerts.confirmAction("¿Deseas empezar a trabajar en esta incidencia?", function() {
        document.getElementById('form-comenzar-' + id).submit();
    });
}

function abrirModalResolver(id, codigo) {
    // Cambiamos el action del form dinámicamente
    const form = document.getElementById('formResolver');
    form.action = "/tecnico/resolver/" + id;
    document.getElementById('codigo_incidencia_modal').innerText = codigo;
    instanciaModal.show();
}

function ejecutarResolucion() {
    const coment = document.getElementById('comentario_resolucion').value;
    if (coment.length < 10) {
        CentralAlerts.toastError("Escribe un comentario técnico válido (min. 10 caracteres).");
        return;
    }
    document.getElementById('formResolver').submit();
}
