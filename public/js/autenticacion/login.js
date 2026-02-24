/**
 * CentralIT — Login JS
 * Validación frontend sin addEventListener, sin required
 */

var campoCorreo = null;
var campoContrasena = null;
var btnLogin = null;

function validarCorreo() {
    var valor = campoCorreo.value.trim();
    var patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var error = document.getElementById('error-correo');

    if (valor === '') {
        error.textContent = 'El correo corporativo es obligatorio.';
        campoCorreo.classList.add('is-invalid');
        return false;
    }

    if (!patron.test(valor)) {
        error.textContent = 'Introduce un correo electrónico válido.';
        campoCorreo.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoCorreo.classList.remove('is-invalid');
    campoCorreo.classList.add('is-valid');
    return true;
}

function validarContrasena() {
    var valor = campoContrasena.value;
    var error = document.getElementById('error-contrasena');

    if (valor === '') {
        error.textContent = 'La contraseña es obligatoria.';
        campoContrasena.classList.add('is-invalid');
        return false;
    }

    if (valor.length < 6) {
        error.textContent = 'La contraseña debe tener al menos 6 caracteres.';
        campoContrasena.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoContrasena.classList.remove('is-invalid');
    campoContrasena.classList.add('is-valid');
    return true;
}

function actualizarBoton() {
    var correoOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campoCorreo.value.trim());
    var contrasenaOk = campoContrasena.value.length >= 6;
    btnLogin.disabled = !(correoOk && contrasenaOk);
}

window.onload = function () {
    campoCorreo = document.getElementById('correo');
    campoContrasena = document.getElementById('contrasena');
    btnLogin = document.getElementById('btnLogin');
    var toggle = document.getElementById('togglePassword');
    var icono = document.getElementById('iconoPassword');
    var flash = document.getElementById('flash-error');

    if (!campoCorreo || !campoContrasena || !btnLogin) return;

    // Mostrar error de sesión con SweetAlert
    if (flash) {
        Swal.fire({
            icon: 'error',
            title: 'Acceso denegado',
            text: flash.dataset.msg,
            confirmButtonColor: '#dc2626'
        });
    }

    // Mostrar éxito de registro con SweetAlert
    var flashSuccess = document.getElementById('flash-success');
    if (flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: '¡Cuenta creada!',
            text: flashSuccess.dataset.msg,
            confirmButtonColor: '#2563eb'
        });
    }

    // Validación en tiempo real
    campoCorreo.oninput = function () {
        validarCorreo();
        actualizarBoton();
    };

    campoCorreo.onblur = function () {
        validarCorreo();
    };

    campoContrasena.oninput = function () {
        validarContrasena();
        actualizarBoton();
    };

    campoContrasena.onblur = function () {
        validarContrasena();
    };

    // Toggle visibilidad contraseña
    if (toggle && icono) {
        toggle.onclick = function () {
            if (campoContrasena.type === 'password') {
                campoContrasena.type = 'text';
                icono.className = 'bi bi-eye';
            } else {
                campoContrasena.type = 'password';
                icono.className = 'bi bi-eye-slash';
            }
        };
    }

    // Validar antes del submit
    document.getElementById('formLogin').onsubmit = function (e) {
        var correoOk = validarCorreo();
        var contrasenaOk = validarContrasena();

        if (!correoOk || !contrasenaOk) {
            e.preventDefault();
        }
    };
};
