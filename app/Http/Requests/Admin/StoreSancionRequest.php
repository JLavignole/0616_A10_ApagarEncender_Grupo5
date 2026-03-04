<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSancionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'tipo'       => ['required', 'string', 'in:advertencia,silencio,bloqueo'],
            'motivo'     => ['required', 'string', 'min:5', 'max:1000'],
            'inicio_en'  => ['nullable', 'date'],
            'fin_en'     => ['nullable', 'date', 'after_or_equal:inicio_en'],
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'Debes seleccionar un usuario.',
            'usuario_id.exists'   => 'El usuario seleccionado no existe.',
            'tipo.required'       => 'Debes seleccionar un tipo de sanción.',
            'tipo.in'             => 'El tipo de sanción no es válido.',
            'motivo.required'     => 'El motivo es obligatorio.',
            'motivo.min'          => 'El motivo debe tener al menos 5 caracteres.',
            'inicio_en.date'      => 'La fecha de inicio no es válida.',
            'fin_en.date'         => 'La fecha de fin no es válida.',
            'fin_en.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    }
}
