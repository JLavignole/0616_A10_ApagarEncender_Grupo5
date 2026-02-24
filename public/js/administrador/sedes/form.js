window.onload = function () {

    const inputCodigo = document.getElementById('codigo');
    const inputNombre = document.getElementById('nombre');
    const eCodigo     = document.getElementById('error-codigo');
    const eNombre     = document.getElementById('error-nombre');
    const form        = document.getElementById('formSede');

    if (!form) return;

    inputCodigo.oninput = function () {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
        comprobarCodigo();
    };

    inputNombre.oninput = function () {
        comprobarNombre();
    };

    inputCodigo.onblur = function () {
        comprobarCodigo();
    };

    inputNombre.onblur = function () {
        comprobarNombre();
    };

    function comprobarCodigo() {
        const valor   = inputCodigo.value.trim();
        const formato = /^[A-Z]{2,5}$/;

        if (valor === '') {
            inputCodigo.classList.add('is-invalid');
            inputCodigo.classList.remove('is-valid');
            eCodigo.innerText = 'El código de sede es obligatorio.';
        } else if (!formato.test(valor)) {
            inputCodigo.classList.add('is-invalid');
            inputCodigo.classList.remove('is-valid');
            eCodigo.innerText = 'Solo letras mayúsculas, entre 2 y 5 caracteres.';
        } else {
            inputCodigo.classList.remove('is-invalid');
            inputCodigo.classList.add('is-valid');
            eCodigo.innerText = '';
        }
    }

    function comprobarNombre() {
        const valor = inputNombre.value.trim();

        if (valor === '') {
            inputNombre.classList.add('is-invalid');
            inputNombre.classList.remove('is-valid');
            eNombre.innerText = 'El nombre de la sede es obligatorio.';
        } else if (valor.length < 2) {
            inputNombre.classList.add('is-invalid');
            inputNombre.classList.remove('is-valid');
            eNombre.innerText = 'El nombre debe tener al menos 2 caracteres.';
        } else {
            inputNombre.classList.remove('is-invalid');
            inputNombre.classList.add('is-valid');
            eNombre.innerText = '';
        }
    }

    form.onsubmit = function (e) {
        const codigoValido = /^[A-Z]{2,5}$/.test(inputCodigo.value.trim());
        const nombreValido = inputNombre.value.trim().length >= 2;

        if (!codigoValido || !nombreValido) {
            e.preventDefault();
            comprobarCodigo();
            comprobarNombre();
            toastError('Corrige los errores antes de guardar.');
            return false;
        }
    };

};
