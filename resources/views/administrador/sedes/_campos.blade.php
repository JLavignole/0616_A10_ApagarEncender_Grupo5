<div class="mb-4">
    <label for="codigo" class="form-label">Código de sede <span class="texto-requerido">*</span></label>
    <input type="text"
           id="codigo"
           name="codigo"
           class="form-control form-control-lg @error('codigo') is-invalid @enderror"
           value="{{ old('codigo', isset($sede) ? $sede->codigo : '') }}"
           placeholder="Ej: BCN, MAD, BER"
           maxlength="5"
           autocomplete="off">
    <div class="form-text">Solo letras mayúsculas, entre 2 y 5 caracteres.</div>
    <div id="error-codigo" class="invalid-feedback d-block">
        @error('codigo'){{ $message }}@enderror
    </div>
</div>

<div class="mb-4">
    <label for="nombre" class="form-label">Nombre de la sede <span class="texto-requerido">*</span></label>
    <input type="text"
           id="nombre"
           name="nombre"
           class="form-control form-control-lg @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', isset($sede) ? $sede->nombre : '') }}"
           placeholder="Ej: Barcelona, Madrid, Berlín"
           maxlength="255"
           autocomplete="off">
    <div id="error-nombre" class="invalid-feedback d-block">
        @error('nombre'){{ $message }}@enderror
    </div>
</div>

<div class="mb-4">
    <label for="zona_horaria" class="form-label">Zona horaria</label>
    <input type="text"
           id="zona_horaria"
           name="zona_horaria"
           class="form-control @error('zona_horaria') is-invalid @enderror"
           value="{{ old('zona_horaria', isset($sede) ? $sede->zona_horaria : '') }}"
           placeholder="Ej: Europe/Madrid, America/Toronto"
           maxlength="80"
           autocomplete="off">
    <div class="form-text">Opcional. Formato: Continent/City.</div>
    @error('zona_horaria')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-2">
    <div class="form-check form-switch">
        <input type="checkbox"
               id="activo"
               name="activo"
               class="form-check-input"
               value="1"
               {{ old('activo', isset($sede) ? $sede->activo : true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activo">Sede activa</label>
    </div>
    <div class="form-text ms-1">
        Las sedes inactivas no permiten registrar nuevos usuarios ni crear incidencias.
    </div>
</div>
