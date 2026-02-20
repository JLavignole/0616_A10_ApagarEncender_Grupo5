@extends('layouts.auth')

@section('title', 'Iniciar sesión – InciTech Corporate')
@section('navbar-title', 'Corporate Login')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
        @csrf

        {{-- Correo / Usuario Corporativo --}}
        <div class="form-group">
            <label for="correo">Usuario Corporativo / ID</label>
            <div class="input-wrapper @error('correo') has-error @enderror">
                <i class="fa-regular fa-user input-icon"></i>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    placeholder="j.perez@incitech.com"
                    autocomplete="email"
                    autofocus
                >
            </div>
            @error('correo')
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
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                <button type="button" class="toggle-password" onclick="togglePassword('contrasena', this)">
                    <i class="fa-regular fa-eye-slash"></i>
                </button>
            </div>
            @error('contrasena')
                <span class="field-error">
                    <i class="fa-solid fa-circle-info"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Link olvidó contraseña --}}
        <div class="form-links">
            <a href="#">¿Olvidó su contraseña?</a>
        </div>

        {{-- Botón submit --}}
        <button type="submit" class="btn-primary">Iniciar sesión</button>

        {{-- Link a registro --}}
        <p class="auth-secondary-link">
            ¿No tiene cuenta corporativa? <a href="{{ route('register') }}">Solicitar acceso</a>
        </p>
    </form>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection
