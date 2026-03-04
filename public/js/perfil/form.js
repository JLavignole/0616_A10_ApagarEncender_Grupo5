/* ── Perfil / form.js ────────────────────────────────────── */

window.onload = function () {

    var inputNombre     = document.getElementById('nombre');
    var inputCorreo     = document.getElementById('correo');
    var inputContrasena = document.getElementById('contrasena');
    var textaBiografia  = document.getElementById('biografia');
    var inputAvatar     = document.getElementById('ruta_avatar');
    var previewAvatar   = document.getElementById('previewAvatar');
    var contadorBio     = document.getElementById('contadorBiografia');
    var eNombre         = document.getElementById('error-nombre');
    var eCorreo         = document.getElementById('error-correo');
    var eContrasena     = document.getElementById('error-contrasena');
    var eBiografia      = document.getElementById('error-biografia');
    var eAvatar         = document.getElementById('error-avatar');
    var form            = document.getElementById('formPerfil');

    if (!form) return;

    // ── Validaciones en tiempo real ──────────────────────────

    inputNombre.oninput = function () {
        comprobarNombre();
    };

    inputNombre.onblur = function () {
        comprobarNombre();
    };

    inputCorreo.oninput = function () {
        comprobarCorreo();
    };

    inputCorreo.onblur = function () {
        comprobarCorreo();
    };

    inputContrasena.oninput = function () {
        comprobarContrasena();
    };

    inputContrasena.onblur = function () {
        comprobarContrasena();
    };

    textaBiografia.oninput = function () {
        actualizarContador();
        comprobarBiografia();
    };

    inputAvatar.onchange = function () {
        comprobarAvatar();
    };

    // ── Preview avatar ───────────────────────────────────────

    function comprobarAvatar() {
        var archivo = inputAvatar.files[0];

        if (!archivo) return;

        var tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        var maxBytes        = 2 * 1024 * 1024;

        if (tiposPermitidos.indexOf(archivo.type) === -1) {
            inputAvatar.classList.add('is-invalid');
            eAvatar.innerText = 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.';
            inputAvatar.value = '';
            return;
        }

        if (archivo.size > maxBytes) {
            inputAvatar.classList.add('is-invalid');
            eAvatar.innerText = 'La imagen no puede superar los 2 MB.';
            inputAvatar.value = '';
            return;
        }

        inputAvatar.classList.remove('is-invalid');
        eAvatar.innerText = '';

        var reader = new FileReader();
        reader.onload = function (evento) {
            previewAvatar.src = evento.target.result;
        };
        reader.readAsDataURL(archivo);
    }

    // ── Contador biografía ───────────────────────────────────

    function actualizarContador() {
        var longitud = textaBiografia.value.length;
        contadorBio.innerText = longitud + '/1000';
        if (longitud > 1000) {
            contadorBio.style.color = '#dc2626';
        } else {
            contadorBio.style.color = '';
        }
    }

    // ── Funciones de validación ──────────────────────────────

    function comprobarNombre() {
        var valor = inputNombre.value.trim();

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
        var valor   = inputCorreo.value.trim();
        var formato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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
        var valor = inputContrasena.value;

        if (valor !== '' && valor.length < 6) {
            inputContrasena.classList.add('is-invalid');
            inputContrasena.classList.remove('is-valid');
            eContrasena.innerText = 'La contraseña debe tener al menos 6 caracteres.';
        } else if (valor !== '') {
            inputContrasena.classList.remove('is-invalid');
            inputContrasena.classList.add('is-valid');
            eContrasena.innerText = '';
        } else {
            inputContrasena.classList.remove('is-invalid', 'is-valid');
            eContrasena.innerText = '';
        }
    }

    function comprobarBiografia() {
        var valor = textaBiografia.value;

        if (valor.length > 1000) {
            textaBiografia.classList.add('is-invalid');
            eBiografia.innerText = 'La biografía no puede superar los 1000 caracteres.';
        } else {
            textaBiografia.classList.remove('is-invalid');
            eBiografia.innerText = '';
        }
    }

    // ── Validación al enviar ─────────────────────────────────

    form.onsubmit = function (evento) {
        comprobarNombre();
        comprobarCorreo();
        comprobarContrasena();
        comprobarBiografia();

        if (form.querySelector('.is-invalid')) {
            evento.preventDefault();
        }
    };
};
