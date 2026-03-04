<div class="mb-4">
    <label for="categoria_id" class="form-label">Categoría <span class="texto-requerido">*</span></label>
    <select id="categoria_id"
            name="categoria_id"
            class="form-select @error('categoria_id') is-invalid @enderror">
        <option value="">— Selecciona una categoría —</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id }}"
                {{ old('categoria_id', isset($subcategoria) ? $subcategoria->categoria_id : '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}{{ $cat->activo ? '' : ' (inactiva)' }}
            </option>
        @endforeach
    </select>
    <div id="error-categoria" class="invalid-feedback d-block">
        @error('categoria_id'){{ $message }}@enderror
    </div>
</div>

<div class="mb-4">
    <label for="nombre" class="form-label">Nombre <span class="texto-requerido">*</span></label>
    <input type="text"
           id="nombre"
           name="nombre"
           class="form-control form-control-lg @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', isset($subcategoria) ? $subcategoria->nombre : '') }}"
           placeholder="Ej: Impresoras, Antivirus, VPN..."
           maxlength="255"
           autocomplete="off">
    <div id="error-nombre" class="invalid-feedback d-block">
        @error('nombre'){{ $message }}@enderror
    </div>
    <div id="aviso-nombre" class="aviso-duplicado"></div>
</div>

<div class="mb-2">
    <div class="form-check form-switch">
        <input type="checkbox"
               id="activo"
               name="activo"
               class="form-check-input"
               value="1"
               {{ old('activo', isset($subcategoria) ? $subcategoria->activo : true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activo">Subcategoría activa</label>
    </div>
    <div class="form-text ms-1">
        Las subcategorías inactivas no estarán disponibles al crear nuevas incidencias.
    </div>
</div>
