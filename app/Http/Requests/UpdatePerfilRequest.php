<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'nombre'       => ['required', 'string', 'min:2', 'max:255'],
            'correo'       => ['required', 'string', 'max:255', 'unique:usuarios,correo,' . $userId],
            'contrasena'   => ['nullable', 'string', 'min:6'],
            'ruta_avatar'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'apellidos'    => ['nullable', 'string', 'max:255'],
            'telefono'     => ['nullable', 'string', 'max:50'],
            'cargo'        => ['nullable', 'string', 'max:100'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'biografia'    => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.min'           => 'El nombre debe tener al menos 2 caracteres.',
            'correo.required'      => 'El correo electrónico es obligatorio.',
            'correo.unique'        => 'Este correo ya está en uso por otra cuenta.',
            'contrasena.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'ruta_avatar.image'    => 'El archivo debe ser una imagen.',
            'ruta_avatar.mimes'    => 'Formatos permitidos: JPG, PNG, GIF, WEBP.',
            'ruta_avatar.max'      => 'La imagen no puede superar los 2 MB.',
            'biografia.max'        => 'La biografía no puede superar los 1000 caracteres.',
        ];
    }
}
