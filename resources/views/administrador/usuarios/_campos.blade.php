<div class="row g-4">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre <span class="texto-requerido">*</span></label>
        <input type="text"
               id="nombre"
               name="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre', isset($usuario) ? $usuario->nombre : '') }}"
               placeholder="Nombre completo"
               maxlength="255"
               autocomplete="off">
        <div id="error-nombre" class="invalid-feedback d-block">
            @error('nombre'){{ $message }}@enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="correo" class="form-label">Correo electrónico <span class="texto-requerido">*</span></label>
        <input type="text"
               id="correo"
               name="correo"
               class="form-control @error('correo') is-invalid @enderror"
               value="{{ old('correo', isset($usuario) ? $usuario->correo : '') }}"
               placeholder="correo@ejemplo.com"
               maxlength="255"
               autocomplete="off">
        <div id="error-correo" class="invalid-feedback d-block">
            @error('correo'){{ $message }}@enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="contrasena" class="form-label">
            Contraseña @if(!isset($usuario))<span class="texto-requerido">*</span>@endif
        </label>
        <input type="password"
               id="contrasena"
               name="contrasena"
               class="form-control @error('contrasena') is-invalid @enderror"
               placeholder="{{ isset($usuario) ? 'Dejar vacío para no cambiar' : 'Mínimo 6 caracteres' }}"
               autocomplete="new-password">
        <div id="error-contrasena" class="invalid-feedback d-block">
            @error('contrasena'){{ $message }}@enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="sede_id" class="form-label">Sede <span class="texto-requerido">*</span></label>
        <select id="sede_id" name="sede_id" class="form-control @error('sede_id') is-invalid @enderror">
            <option value="">Selecciona una sede...</option>
            @foreach($sedes as $sede)
                <option value="{{ $sede->id }}" {{ old('sede_id', isset($usuario) ? $usuario->sede_id : '') == $sede->id ? 'selected' : '' }}>
                    {{ $sede->nombre }} ({{ $sede->codigo }})
                </option>
            @endforeach
        </select>
        <div id="error-sede" class="invalid-feedback d-block">
            @error('sede_id'){{ $message }}@enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="rol_id" class="form-label">Rol <span class="texto-requerido">*</span></label>
        <select id="rol_id" name="rol_id" class="form-control @error('rol_id') is-invalid @enderror">
            <option value="">Selecciona un rol...</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}" {{ old('rol_id', isset($usuario) ? $usuario->rol_id : '') == $rol->id ? 'selected' : '' }}>
                    {{ ucfirst($rol->nombre) }}
                </option>
            @endforeach
        </select>
        <div id="error-rol" class="invalid-feedback d-block">
            @error('rol_id'){{ $message }}@enderror
        </div>
    </div>

    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox"
                   id="activo"
                   name="activo"
                   class="form-check-input"
                   value="1"
                   {{ old('activo', isset($usuario) ? $usuario->activo : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">Usuario activo</label>
        </div>
    </div>
</div>
