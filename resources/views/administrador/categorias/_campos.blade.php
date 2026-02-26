<div class="mb-4">
    <label for="nombre" class="form-label">Nombre <span class="texto-requerido">*</span></label>
    <input type="text"
           id="nombre"
           name="nombre"
           class="form-control form-control-lg @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', isset($categoria) ? $categoria->nombre : '') }}"
           placeholder="Ej: Hardware, Software, Red..."
           maxlength="255"
           autocomplete="off">
    <div id="error-nombre" class="invalid-feedback d-block">
        @error('nombre'){{ $message }}@enderror
    </div>
</div>

<div class="mb-2">
    <div class="form-check form-switch">
        <input type="checkbox"
               id="activo"
               name="activo"
               class="form-check-input"
               value="1"
               {{ old('activo', isset($categoria) ? $categoria->activo : true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activo">Categoría activa</label>
    </div>
    <div class="form-text ms-1">
        Las categorías inactivas no estarán disponibles al crear nuevas incidencias.
    </div>
</div>
