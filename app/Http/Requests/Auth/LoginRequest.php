<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'correo'     => ['required', 'string', 'email', 'max:255'],
            'contrasena' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'correo.required'     => 'El correo corporativo es obligatorio.',
            'correo.email'        => 'Introduce un correo electrónico válido.',
            'correo.max'          => 'El correo no puede superar los 255 caracteres.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'correo'     => 'correo electrónico',
            'contrasena' => 'contraseña',
        ];
    }
}
