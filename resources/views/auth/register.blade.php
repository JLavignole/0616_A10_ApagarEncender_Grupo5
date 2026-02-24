@extends('layouts.auth')

@section('title', 'Registro – InciTech Corporate')
@section('navbar-title', 'Corporate Register')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
        @csrf

        {{-- Nombre --}}
        <div class="form-group">
            <label for="nombre">Nombre completo</label>
            <div class="input-wrapper @error('nombre') has-error @enderror">
                <i class="fa-regular fa-user input-icon"></i>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Juan Pérez García"
                    autocomplete="name"
                    autofocus
                >
            </div>
            @error('nombre')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Correo --}}
        <div class="form-group">
            <label for="correo">Correo corporativo</label>
            <div class="input-wrapper @error('correo') has-error @enderror">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    placeholder="j.perez@incitech.com"
                    autocomplete="email"
                >
            </div>
            @error('correo')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Sede --}}
        <div class="form-group">
            <label for="sede_id">Sede</label>
            <div class="input-wrapper @error('sede_id') has-error @enderror">
                <i class="fa-solid fa-building input-icon"></i>
                <select id="sede_id" name="sede_id">
                    <option value="">Seleccione una sede</option>
                    @foreach ($sedes as $sede)
                        <option value="{{ $sede->id }}" @selected(old('sede_id') == $sede->id)>
                            {{ $sede->nombre }} ({{ $sede->codigo }})
                        </option>
                    @endforeach
                </select>
            </div>
            @error('sede_id')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <div class="input-wrapper @error('contrasena') has-error @enderror">
                <i class="fa-solid fa-lock input-icon"></i>
                <input
                    type="password"
                    id="contrasena"
                    name="contrasena"
                    placeholder="Mínimo 8 caracteres"
                    autocomplete="new-password"
                >
                <button type="button" class="toggle-password">
                    <i class="fa-regular fa-eye-slash"></i>
                </button>
            </div>
            @error('contrasena')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div class="form-group">
            <label for="contrasena_confirmation">Confirmar contraseña</label>
            <div class="input-wrapper @error('contrasena_confirmation') has-error @enderror">
                <i class="fa-solid fa-lock input-icon"></i>
                <input
                    type="password"
                    id="contrasena_confirmation"
                    name="contrasena_confirmation"
                    placeholder="Repita la contraseña"
                    autocomplete="new-password"
                >
                <button type="button" class="toggle-password">
                    <i class="fa-regular fa-eye-slash"></i>
                </button>
            </div>
            @error('contrasena_confirmation')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Botón submit --}}
        <button type="submit" class="btn-primary">Crear cuenta</button>

        {{-- Link a login --}}
        <p class="auth-secondary-link">
            ¿Ya tiene cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
        </p>
    </form>
@endsection
