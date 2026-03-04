/**
 * CentralIT — Register JS
 * Validación frontend sin addEventListener, sin required
 */

var campoNombre = null;
var campoCorreo = null;
var campoSede = null;
var campoContrasena = null;
var campoConfirmacion = null;
var btnRegister = null;

function validarNombre() {
    var valor = campoNombre.value.trim();
    var error = document.getElementById('error-nombre');

    if (valor === '') {
        error.textContent = 'El nombre es obligatorio.';
        campoNombre.classList.add('is-invalid');
        return false;
    }

    if (valor.length < 2) {
        error.textContent = 'El nombre debe tener al menos 2 caracteres.';
        campoNombre.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoNombre.classList.remove('is-invalid');
    campoNombre.classList.add('is-valid');
    return true;
}

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

function validarSede() {
    var valor = campoSede.value;
    var error = document.getElementById('error-sede');

    if (valor === '') {
        error.textContent = 'Debe seleccionar una sede.';
        campoSede.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoSede.classList.remove('is-invalid');
    campoSede.classList.add('is-valid');
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

    if (valor.length < 8) {
        error.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        campoContrasena.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoContrasena.classList.remove('is-invalid');
    campoContrasena.classList.add('is-valid');
    return true;
}

function validarConfirmacion() {
    var valor = campoConfirmacion.value;
    var error = document.getElementById('error-confirmacion');

    if (valor === '') {
        error.textContent = 'Debes confirmar la contraseña.';
        campoConfirmacion.classList.add('is-invalid');
        return false;
    }

    if (valor !== campoContrasena.value) {
        error.textContent = 'Las contraseñas no coinciden.';
        campoConfirmacion.classList.add('is-invalid');
        return false;
    }

    error.textContent = '';
    campoConfirmacion.classList.remove('is-invalid');
    campoConfirmacion.classList.add('is-valid');
    return true;
}

function actualizarBoton() {
    var nombreOk = campoNombre.value.trim().length >= 2;
    var correoOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campoCorreo.value.trim());
    var sedeOk = campoSede.value !== '';
    var contrasenaOk = campoContrasena.value.length >= 8;
    var confirmOk = campoConfirmacion.value === campoContrasena.value && campoConfirmacion.value.length > 0;

    btnRegister.disabled = !(nombreOk && correoOk && sedeOk && contrasenaOk && confirmOk);
}

window.onload = function () {
    campoNombre = document.getElementById('nombre');
    campoCorreo = document.getElementById('correo');
    campoSede = document.getElementById('sede_id');
    campoContrasena = document.getElementById('contrasena');
    campoConfirmacion = document.getElementById('contrasena_confirmation');
    btnRegister = document.getElementById('btnRegister');
    var toggle = document.getElementById('togglePassword');
    var icono = document.getElementById('iconoPassword');
    var flash = document.getElementById('flash-error');

    if (!campoNombre || !campoCorreo || !campoSede || !campoContrasena || !campoConfirmacion || !btnRegister) return;

    // Mostrar error de servidor con SweetAlert
    if (flash) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: flash.dataset.msg,
            confirmButtonColor: '#dc2626'
        });
    }

    // Validación en tiempo real
    campoNombre.oninput = function () {
        validarNombre();
        actualizarBoton();
    };

    campoNombre.onblur = function () {
        validarNombre();
    };

    campoCorreo.oninput = function () {
        validarCorreo();
        actualizarBoton();
    };

    campoCorreo.onblur = function () {
        validarCorreo();
    };

    campoSede.onchange = function () {
        validarSede();
        actualizarBoton();
    };

    campoContrasena.oninput = function () {
        validarContrasena();
        // Revalidar confirmación si ya tiene contenido
        if (campoConfirmacion.value.length > 0) {
            validarConfirmacion();
        }
        actualizarBoton();
    };

    campoContrasena.onblur = function () {
        validarContrasena();
    };

    campoConfirmacion.oninput = function () {
        validarConfirmacion();
        actualizarBoton();
    };

    campoConfirmacion.onblur = function () {
        validarConfirmacion();
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
    document.getElementById('formRegister').onsubmit = function (e) {
        var nombreOk = validarNombre();
        var correoOk = validarCorreo();
        var sedeOk = validarSede();
        var passOk = validarContrasena();
        var confirmOk = validarConfirmacion();

        if (!nombreOk || !correoOk || !sedeOk || !passOk || !confirmOk) {
            e.preventDefault();
        }
    };
};
