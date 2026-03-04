/* ── Administrador / Categorías / form.js ───────────────── */

window.onload = function () {
    const form        = document.getElementById('formCategoria');
    const inputNombre = document.getElementById('nombre');
    const eNombre     = document.getElementById('error-nombre');

    if (!form) return;

    inputNombre.oninput = function () {
        comprobarNombre();
    };

    inputNombre.onblur = function () {
        comprobarNombre();
    };

    function comprobarNombre() {
        const val = inputNombre.value.trim();

        if (val === '') {
            inputNombre.classList.add('is-invalid');
            inputNombre.classList.remove('is-valid');
            eNombre.innerText = 'El nombre es obligatorio.';
            return false;
        }

        if (val.length < 2) {
            inputNombre.classList.add('is-invalid');
            inputNombre.classList.remove('is-valid');
            eNombre.innerText = 'El nombre debe tener al menos 2 caracteres.';
            return false;
        }

        inputNombre.classList.remove('is-invalid');
        inputNombre.classList.add('is-valid');
        eNombre.innerText = '';
        return true;
    }

    form.onsubmit = function (e) {
        const nombreOk = comprobarNombre();

        if (!nombreOk) {
            e.preventDefault();
            toastError('Corrige los errores antes de guardar.');
        }
    };
};
