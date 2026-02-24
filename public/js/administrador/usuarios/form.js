window.onload = function () {

    const inputNombre     = document.getElementById('nombre');
    const inputCorreo     = document.getElementById('correo');
    const inputContrasena = document.getElementById('contrasena');
    const selectSede      = document.getElementById('sede_id');
    const selectRol       = document.getElementById('rol_id');
    const eNombre         = document.getElementById('error-nombre');
    const eCorreo         = document.getElementById('error-correo');
    const eContrasena     = document.getElementById('error-contrasena');
    const eSede           = document.getElementById('error-sede');
    const eRol            = document.getElementById('error-rol');
    const form            = document.getElementById('formUsuario');
    const esEdicion       = form.getAttribute('data-edicion') === 'true';

    if (!form) return;

    inputNombre.oninput = function () {
        comprobarNombre();
    };

    inputCorreo.oninput = function () {
        comprobarCorreo();
    };

    inputContrasena.oninput = function () {
        comprobarContrasena();
    };

    inputNombre.onblur = function () {
        comprobarNombre();
    };

    inputCorreo.onblur = function () {
        comprobarCorreo();
    };

    inputContrasena.onblur = function () {
        comprobarContrasena();
    };

    selectSede.onblur = function () {
        comprobarSede();
    };

    selectRol.onblur = function () {
        comprobarRol();
    };

    function comprobarNombre() {
        const valor = inputNombre.value.trim();

        if (valor === '') {
            inputNombre.classList.add('is-invalid');
            inputNombre.classList.remove('is-valid');
            eNombre.innerText = 'El nombre es obligatorio.';
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

    function comprobarCorreo() {
        const valor   = inputCorreo.value.trim();
        const formato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (valor === '') {
            inputCorreo.classList.add('is-invalid');
            inputCorreo.classList.remove('is-valid');
            eCorreo.innerText = 'El correo electrónico es obligatorio.';
        } else if (!formato.test(valor)) {
            inputCorreo.classList.add('is-invalid');
            inputCorreo.classList.remove('is-valid');
            eCorreo.innerText = 'Introduce un correo electrónico válido.';
        } else {
            inputCorreo.classList.remove('is-invalid');
            inputCorreo.classList.add('is-valid');
            eCorreo.innerText = '';
        }
    }

    function comprobarContrasena() {
        const valor = inputContrasena.value;

        if (!esEdicion && valor === '') {
            inputContrasena.classList.add('is-invalid');
            inputContrasena.classList.remove('is-valid');
            eContrasena.innerText = 'La contraseña es obligatoria.';
        } else if (valor !== '' && valor.length < 6) {
            inputContrasena.classList.add('is-invalid');
            inputContrasena.classList.remove('is-valid');
            eContrasena.innerText = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            inputContrasena.classList.remove('is-invalid');
            inputContrasena.classList.add('is-valid');
            eContrasena.innerText = '';
        }
    }

    function comprobarSede() {
        if (selectSede.value === '') {
            selectSede.classList.add('is-invalid');
            selectSede.classList.remove('is-valid');
            eSede.innerText = 'Selecciona una sede.';
            return false;
        } else {
            selectSede.classList.remove('is-invalid');
            selectSede.classList.add('is-valid');
            eSede.innerText = '';
            return true;
        }
    }

    function comprobarRol() {
        if (selectRol.value === '') {
            selectRol.classList.add('is-invalid');
            selectRol.classList.remove('is-valid');
            eRol.innerText = 'Selecciona un rol.';
            return false;
        } else {
            selectRol.classList.remove('is-invalid');
            selectRol.classList.add('is-valid');
            eRol.innerText = '';
            return true;
        }
    }

    form.onsubmit = function (e) {
        const nombreValido     = inputNombre.value.trim().length >= 2;
        const correoValido     = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputCorreo.value.trim());
        const contrasenaValida = esEdicion
            ? (inputContrasena.value === '' || inputContrasena.value.length >= 6)
            : inputContrasena.value.length >= 6;
        const sedeValida = selectSede.value !== '';
        const rolValido  = selectRol.value !== '';

        if (!nombreValido || !correoValido || !contrasenaValida || !sedeValida || !rolValido) {
            e.preventDefault();
            comprobarNombre();
            comprobarCorreo();
            comprobarContrasena();
            comprobarSede();
            comprobarRol();
            toastError('Corrige los errores antes de guardar.');
            return false;
        }
    };

};
