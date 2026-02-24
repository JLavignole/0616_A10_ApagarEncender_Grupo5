/**
 * Cliente — Incidencias (subcategorías AJAX, cierre, preview imagen)
 */
window.onload = function () {

    // ── 5.3 Subcategorías AJAX ─────────────────────────
    var selectCategoria    = document.getElementById('categoria_id');
    var selectSubcategoria = document.getElementById('subcategoria_id');

    if (selectCategoria && selectSubcategoria) {
        selectCategoria.onchange = function () {
            var categoriaId = this.value;

            // Resetear subcategoría
            selectSubcategoria.innerHTML = '<option value="">Selecciona subcategoría...</option>';
            selectSubcategoria.disabled = true;

            if (!categoriaId) return;

            var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch('/api/categorias/' + categoriaId + '/subcategorias', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(function (response) {
                if (!response.ok) throw new Error('Error en la respuesta');
                return response.json();
            })
            .then(function (subcategorias) {
                selectSubcategoria.innerHTML = '<option value="">Selecciona subcategoría...</option>';

                for (var i = 0; i < subcategorias.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = subcategorias[i].id;
                    opt.textContent = subcategorias[i].nombre;
                    selectSubcategoria.appendChild(opt);
                }

                selectSubcategoria.disabled = false;
            })
            .catch(function () {
                selectSubcategoria.innerHTML = '<option value="">Error al cargar</option>';
            });
        };
    }

    // ── 5.5 Confirmación de cierre ─────────────────────
    var btnCerrar = document.getElementById('btn-cerrar-incidencia');

    if (btnCerrar) {
        btnCerrar.onclick = function (e) {
            e.preventDefault();
            var codigo = this.getAttribute('data-codigo');

            Swal.fire({
                title: '¿Cerrar incidencia?',
                text: 'Se cerrará la incidencia ' + codigo + '. Esto confirma que el problema ha sido resuelto satisfactoriamente.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cerrar',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    document.getElementById('form-cerrar-incidencia').submit();
                }
            });
        };
    }

    // ── 5.4 Preview de imagen al seleccionar ───────────
    var inputImagen = document.getElementById('imagen');
    var preview     = document.getElementById('imagen-preview');

    if (inputImagen && preview) {
        inputImagen.onchange = function () {
            if (this.files && this.files[0]) {
                var file = this.files[0];

                // Validar tamaño máximo 3 MB
                if (file.size > 3 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo demasiado grande',
                        text: 'La imagen no puede superar los 3 MB.',
                        confirmButtonColor: '#dc2626'
                    });
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        };
    }

    // ── Auto-submit filtros al cambiar select ──────────
    var filtros = document.querySelectorAll('.filtros-incidencias select');
    for (var i = 0; i < filtros.length; i++) {
        filtros[i].onchange = function () {
            this.closest('form').submit();
        };
    }
};
