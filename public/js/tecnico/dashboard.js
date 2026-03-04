// Variable global para el modal
var modalResolucion = null;

window.onload = function () {
    // Inicializamos el modal al cargar la página para que esté listo
    var elementoModal = document.getElementById('modalResolver');
    if (elementoModal) {
        modalResolucion = new bootstrap.Modal(elementoModal);
    }
};


// Función para el botón "Comenzar"
// Se activa directamente desde el onclick del HTML

function ejecutarComienzo(id, codigo) {
    Swal.fire({
        title: '¿Empezar trabajo?',
        text: 'La incidencia ' + codigo + ' pasará a estado «En trabajo».',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        confirmButtonText: 'Sí, comenzar',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.isConfirmed) {
            // Buscamos el formulario específico de esa fila por su ID
            var formulario = document.getElementById('form-comenzar-' + id);
            if (formulario) {
                formulario.submit();
            }
        }
    });
}


// Función para preparar y abrir el modal de "Resolver"

function abrirModalResolver(id, codigo) {
    // 1. Ponemos el código en el título del modal
    document.getElementById('modalCodigo').innerText = codigo;
    
    // 2. Configuramos a dónde se enviará el formulario de resolución
    var form = document.getElementById('formResolver');
    form.action = "/tecnico/resolver/" + id;
    
    // 3. Limpiamos el texto anterior y abrimos
    document.getElementById('comentario').value = "";
    document.getElementById('comentario').classList.remove('is-invalid');
    modalResolucion.show();
}


// Función que valida el comentario y envía la resolución final

function validarYEnviar() {
    var campoComentario = document.getElementById('comentario');
    var texto = campoComentario.value;
    
    if (texto.length < 10) {
        campoComentario.classList.add('is-invalid');
        Swal.fire({
            title: 'Atención',
            text: 'Debes explicar brevemente la solución (mínimo 10 letras).',
            icon: 'warning'
        });
        return;
    }
    
    // Si todo está bien, confirmación final y envío
    Swal.fire({
        title: '¿Finalizar incidencia?',
        text: "Se registrará la solución y la fecha de hoy.",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        confirmButtonText: 'Sí, finalizar'
    }).then(function(result) {
        if (result.isConfirmed) {
            document.getElementById('formResolver').submit();
        }
    });
}
