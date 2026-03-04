/* ── Administrador / Incidencias / form.js ──────────────── */

window.onload = function () {
    const form              = document.getElementById('formIncidencia');
    const selectCategoria   = document.getElementById('categoria_id');
    const selectSubcategoria = document.getElementById('subcategoria_id');

    if (!form) return;

    const urlTemplate       = form.dataset.urlSubcategorias || '';
    const subcategoriaActual = form.dataset.subcategoriaActual || '';

    // ── Carga subcategorías vía AJAX ──────────────────────────

    function cargarSubcategorias(categoriaId, seleccionar) {
        if (!categoriaId) {
            selectSubcategoria.innerHTML = '<option value="">Selecciona subcategoría...</option>';
            return;
        }

        const url = urlTemplate.replace('__ID__', categoriaId);

        fetch(url)
            .then(function (response) {
                return response.json();
            })
            .then(function (lista) {
                selectSubcategoria.innerHTML = '<option value="">Selecciona subcategoría...</option>';

                for (var i = 0; i < lista.length; i++) {
                    const opt = document.createElement('option');
                    opt.value = lista[i].id;
                    opt.textContent = lista[i].nombre;
                    if (String(lista[i].id) === String(seleccionar)) {
                        opt.selected = true;
                    }
                    selectSubcategoria.appendChild(opt);
                }
            });
    }

    // Al cambiar categoría carga subcategorías sin pre-selección
    selectCategoria.onchange = function () {
        cargarSubcategorias(this.value, '');
    };

    // Carga inicial con subcategoría actual pre-seleccionada
    if (selectCategoria.value) {
        cargarSubcategorias(selectCategoria.value, subcategoriaActual);
    }

    // ── Validación básica al enviar ───────────────────────────

    form.onsubmit = function (e) {
        let valido = true;

        if (!selectCategoria.value) {
            selectCategoria.classList.add('is-invalid');
            valido = false;
        } else {
            selectCategoria.classList.remove('is-invalid');
        }

        if (!selectSubcategoria.value) {
            selectSubcategoria.classList.add('is-invalid');
            valido = false;
        } else {
            selectSubcategoria.classList.remove('is-invalid');
        }

        if (!valido) {
            e.preventDefault();
            toastError('Completa todos los campos obligatorios.');
        }
    };
};
