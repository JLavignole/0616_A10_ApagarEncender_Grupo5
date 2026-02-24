/* public/js/gestor/incidencias.js */

/**
 * Gestor Incidencias — Filtro ocultar cerradas + Modal de asignación
 * Usa fetch() con .then() para el POST de asignación
 */

var urlAsignar = '';

// ── Checkbox ocultar cerradas ──
var chkOcultar = document.getElementById('chkOcultarCerradas');
if (chkOcultar) {
    chkOcultar.onclick = function () {
        var filas = document.querySelectorAll('.fila-incidencia');
        for (var i = 0; i < filas.length; i++) {
            if (filas[i].getAttribute('data-estado') === 'cerrada') {
                if (chkOcultar.checked) {
                    filas[i].classList.add('oculta');
                } else {
                    filas[i].classList.remove('oculta');
                }
            }
        }
    };
}

// ── Abrir modal ──
var botonesAbrir = document.querySelectorAll('.btn-abrir-asignar');
for (var i = 0; i < botonesAbrir.length; i++) {
    botonesAbrir[i].onclick = function () {
        var codigo = this.getAttribute('data-codigo') || '—';
        urlAsignar = this.getAttribute('data-url') || '';

        document.getElementById('modalCodigoInc').textContent = codigo;
        document.getElementById('selectPrioridad').value = '';
        document.getElementById('selectTecnico').value = '';
        document.getElementById('modalAsignar').removeAttribute('hidden');
    };
}

// ── Cerrar modal ──
function cerrarModal() {
    document.getElementById('modalAsignar').setAttribute('hidden', '');
    urlAsignar = '';
}

var btnCerrar = document.getElementById('btnCerrarModal');
if (btnCerrar) {
    btnCerrar.onclick = cerrarModal;
}

var btnCancelar = document.getElementById('btnCancelarModal');
if (btnCancelar) {
    btnCancelar.onclick = cerrarModal;
}

// Cerrar al hacer clic fuera
var overlay = document.getElementById('modalAsignar');
if (overlay) {
    overlay.onclick = function (e) {
        if (e.target === overlay) {
            cerrarModal();
        }
    };
}

// ── Confirmar asignación con fetch() ──
var btnConfirmar = document.getElementById('btnConfirmarAsignar');
if (btnConfirmar) {
    btnConfirmar.onclick = function () {
        var prioridad = document.getElementById('selectPrioridad').value;
        var tecnicoId = document.getElementById('selectTecnico').value;

        if (!prioridad) {
            toastError('Selecciona una prioridad');
            return;
        }
        if (!tecnicoId) {
            toastError('Selecciona un técnico');
            return;
        }

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(urlAsignar, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                prioridad: prioridad,
                tecnico_id: tecnicoId
            })
        })
            .then(function (respuesta) {
                return respuesta.json();
            })
            .then(function (datos) {
                cerrarModal();
                if (datos.exito) {
                    toastExito(datos.mensaje);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    toastError(datos.mensaje || 'Error al asignar la incidencia');
                }
            })
            .catch(function (error) {
                cerrarModal();
                toastError('Error de conexión: ' + error.message);
            });
    };
}
