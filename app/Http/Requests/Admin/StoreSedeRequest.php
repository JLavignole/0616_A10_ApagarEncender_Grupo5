<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSedeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'       => ['required', 'string', 'min:2', 'max:5', 'regex:/^[A-Z]+$/', 'unique:sedes,codigo'],
            'nombre'       => ['required', 'string', 'max:255'],
            'zona_horaria' => ['nullable', 'string', 'max:80'],
            'activo'       => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código de sede es obligatorio.',
            'codigo.min'      => 'El código debe tener al menos 2 caracteres.',
            'codigo.max'      => 'El código no puede superar los 5 caracteres.',
            'codigo.regex'    => 'El código solo puede contener letras mayúsculas (A-Z).',
            'codigo.unique'   => 'Este código ya está registrado en otra sede.',
            'nombre.required' => 'El nombre de la sede es obligatorio.',
        ];
    }

    /** Normaliza el código a mayúsculas antes de validar. */
    protected function prepareForValidation(): void
    {
        if ($this->has('codigo')) {
            $this->merge(['codigo' => strtoupper(trim($this->codigo))]);
        }

        // Si el checkbox no viene, activo = false
        $this->merge(['activo' => $this->boolean('activo')]);
    }
}
