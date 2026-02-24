/* ── Administrador / Sanciones / form.js ─────────────────── */

window.onload = function () {
    const form          = document.getElementById('formSancion');
    const selectUsuario = document.getElementById('usuario_id');
    const selectTipo    = document.getElementById('tipo');
    const textareaMotivo = document.getElementById('motivo');
    const inputInicio   = document.getElementById('inicio_en');
    const inputFin      = document.getElementById('fin_en');
    const eUsuario      = document.getElementById('error-usuario');
    const eTipo         = document.getElementById('error-tipo');
    const eMotivo       = document.getElementById('error-motivo');
    const eInicio       = document.getElementById('error-inicio');
    const eFin          = document.getElementById('error-fin');
    const avisoBan      = document.getElementById('avisoBan');

    if (!form) return;

    // ── Mostrar/ocultar aviso de bloqueo ─────────────────────

    selectTipo.onchange = function () {
        if (selectTipo.value === 'bloqueo') {
            avisoBan.style.display = 'block';
        } else {
            avisoBan.style.display = 'none';
        }
        comprobarTipo();
    };

    // ── Validaciones ─────────────────────────────────────────

    function comprobarUsuario() {
        const val = selectUsuario.value;

        if (!val || val === '') {
            selectUsuario.classList.add('is-invalid');
            selectUsuario.classList.remove('is-valid');
            eUsuario.innerText = 'Debes seleccionar un usuario.';
            return false;
        }

        selectUsuario.classList.remove('is-invalid');
        selectUsuario.classList.add('is-valid');
        eUsuario.innerText = '';
        return true;
    }

    function comprobarTipo() {
        const val = selectTipo.value;

        if (!val || val === '') {
            selectTipo.classList.add('is-invalid');
            selectTipo.classList.remove('is-valid');
            eTipo.innerText = 'Debes seleccionar un tipo de sanción.';
            return false;
        }

        selectTipo.classList.remove('is-invalid');
        selectTipo.classList.add('is-valid');
        eTipo.innerText = '';
        return true;
    }

    function comprobarMotivo() {
        const val = textareaMotivo.value.trim();

        if (val === '') {
            textareaMotivo.classList.add('is-invalid');
            textareaMotivo.classList.remove('is-valid');
            eMotivo.innerText = 'El motivo es obligatorio.';
            return false;
        }

        if (val.length < 5) {
            textareaMotivo.classList.add('is-invalid');
            textareaMotivo.classList.remove('is-valid');
            eMotivo.innerText = 'El motivo debe tener al menos 5 caracteres.';
            return false;
        }

        textareaMotivo.classList.remove('is-invalid');
        textareaMotivo.classList.add('is-valid');
        eMotivo.innerText = '';
        return true;
    }

    function comprobarFechas() {
        const inicio = inputInicio.value;
        const fin    = inputFin.value;

        eFin.innerText = '';
        inputFin.classList.remove('is-invalid');

        if (inicio && fin) {
            const dtInicio = new Date(inicio);
            const dtFin    = new Date(fin);

            if (dtFin < dtInicio) {
                inputFin.classList.add('is-invalid');
                eFin.innerText = 'La fecha de fin debe ser igual o posterior a la fecha de inicio.';
                return false;
            }
        }

        return true;
    }

    // ── Eventos ──────────────────────────────────────────────

    selectUsuario.onchange = function () {
        comprobarUsuario();
    };

    textareaMotivo.oninput = function () {
        comprobarMotivo();
    };

    textareaMotivo.onblur = function () {
        comprobarMotivo();
    };

    inputInicio.onchange = function () {
        comprobarFechas();
    };

    inputFin.onchange = function () {
        comprobarFechas();
    };

    // ── Submit ───────────────────────────────────────────────

    form.onsubmit = function (e) {
        const usuarioOk = comprobarUsuario();
        const tipoOk    = comprobarTipo();
        const motivoOk  = comprobarMotivo();
        const fechasOk  = comprobarFechas();

        if (!usuarioOk || !tipoOk || !motivoOk || !fechasOk) {
            e.preventDefault();
            toastError('Corrige los errores antes de guardar.');
            return;
        }

        if (selectTipo.value === 'bloqueo') {
            e.preventDefault();
            Swal.fire({
                title: '¿Confirmar bloqueo?',
                text: 'El usuario no podrá iniciar sesión mientras la sanción esté activa.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, bloquear',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    form.submit();
                }
            });
        }
    };
};
