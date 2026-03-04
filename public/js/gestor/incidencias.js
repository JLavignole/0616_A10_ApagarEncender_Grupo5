/* public/js/gestor/incidencias.js */

window.onload = function () {

    /* ── Filtros ─────────────────────────────────────────── */
    var formFiltros      = document.getElementById('formFiltros');
    var inputBuscar      = document.getElementById('inputBuscar');
    var selectEstado     = document.getElementById('selectEstado');
    var selectPrioridad  = document.getElementById('selectPrioridad');
    var selectOrden      = document.getElementById('selectOrden');

    var timerBuscar = null;

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timerBuscar);
            timerBuscar = setTimeout(function () {
                formFiltros.submit();
            }, 400);
        };
    }

    if (selectEstado) {
        selectEstado.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectPrioridad) {
        selectPrioridad.onchange = function () {
            formFiltros.submit();
        };
    }

    if (selectOrden) {
        selectOrden.onchange = function () {
            formFiltros.submit();
        };
    }

    /* ── Checkbox ocultar cerradas ────────────────────── */
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

    /* ── Modal de asignación ─────────────────────────── */
    var urlAsignar = '';

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

    var overlay = document.getElementById('modalAsignar');
    if (overlay) {
        overlay.onclick = function (e) {
            if (e.target === overlay) {
                cerrarModal();
            }
        };
    }

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
};
