<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('correo')) {
            $this->merge(['correo' => strtolower(trim($this->correo))]);
        }
    }

    public function rules(): array
    {
        $usuarioId = $this->route('usuario')->id;

        return [
            'nombre'      => ['required', 'string', 'min:2', 'max:255'],
            'correo'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuarios', 'correo')->ignore($usuarioId),
            ],
            'contrasena'  => ['nullable', 'string', 'min:6'],
            'sede_id'     => [
                'required',
                'integer',
                Rule::exists('sedes', 'id')->where('activo', true),
            ],
            'rol_id'      => ['required', 'integer', 'exists:roles,id'],
            'activo'      => ['nullable', 'boolean'],
            'ruta_avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'  => 'El nombre es obligatorio.',
            'nombre.min'       => 'El nombre debe tener al menos 2 caracteres.',
            'correo.required'  => 'El correo electrónico es obligatorio.',
            'correo.email'     => 'Introduce un correo electrónico válido.',
            'correo.unique'    => 'Este correo ya está registrado.',
            'contrasena.min'   => 'La contraseña debe tener al menos 6 caracteres.',
            'sede_id.required' => 'La sede es obligatoria.',
            'sede_id.exists'   => 'La sede seleccionada no existe o está inactiva.',
            'rol_id.required'  => 'El rol es obligatorio.',
            'rol_id.exists'    => 'El rol seleccionado no es válido.',
        ];
    }
}
