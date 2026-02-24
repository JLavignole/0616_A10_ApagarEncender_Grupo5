/* ── Administrador / Subcategorías / form.js ────────────── */

window.onload = function () {
    const form           = document.getElementById('formSubcategoria');
    const selectCategoria = document.getElementById('categoria_id');
    const inputNombre    = document.getElementById('nombre');
    const eCategoria     = document.getElementById('error-categoria');
    const eNombre        = document.getElementById('error-nombre');
    const avisoNombre    = document.getElementById('aviso-nombre');

    const urlTemplate         = form.dataset.urlPorCategoria || '';
    const subcategoriaActualId = form.dataset.subcategoriaId || '';

    let timerDup = null;

    if (!form) return;

    // ── Validaciones ─────────────────────────────────────────

    function comprobarCategoria() {
        const val = selectCategoria.value;

        if (val === '' || val === '0') {
            selectCategoria.classList.add('is-invalid');
            selectCategoria.classList.remove('is-valid');
            eCategoria.innerText = 'Debes seleccionar una categoría.';
            return false;
        }

        selectCategoria.classList.remove('is-invalid');
        selectCategoria.classList.add('is-valid');
        eCategoria.innerText = '';
        return true;
    }

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

    // ── Comprobación de duplicado vía fetch ──────────────────

    function comprobarDuplicado() {
        const catId = selectCategoria.value;
        const nombre = inputNombre.value.trim();

        avisoNombre.innerText = '';

        if (!catId || catId === '0' || nombre.length < 2) return;

        clearTimeout(timerDup);
        timerDup = setTimeout(function () {
            const url = urlTemplate.replace('__ID__', catId);

            fetch(url)
                .then(function (response) {
                    return response.json();
                })
                .then(function (lista) {
                    const existe = lista.some(function (sub) {
                        if (subcategoriaActualId && sub.id == subcategoriaActualId) {
                            return false;
                        }
                        return sub.nombre.toLowerCase() === nombre.toLowerCase();
                    });

                    if (existe) {
                        avisoNombre.innerText = 'Ya existe una subcategoría con ese nombre en la categoría seleccionada.';
                    } else {
                        avisoNombre.innerText = '';
                    }
                })
                .catch(function () {
                    avisoNombre.innerText = '';
                });
        }, 400);
    }

    // ── Eventos ──────────────────────────────────────────────

    selectCategoria.onchange = function () {
        comprobarCategoria();
        comprobarDuplicado();
    };

    inputNombre.oninput = function () {
        comprobarNombre();
        comprobarDuplicado();
    };

    inputNombre.onblur = function () {
        comprobarNombre();
    };

    // ── Submit ───────────────────────────────────────────────

    form.onsubmit = function (e) {
        const categoriaOk = comprobarCategoria();
        const nombreOk    = comprobarNombre();

        if (!categoriaOk || !nombreOk) {
            e.preventDefault();
            toastError('Corrige los errores antes de guardar.');
        }
    };
};
