<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubcategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'nombre'       => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('subcategorias', 'nombre')->where('categoria_id', $this->input('categoria_id')),
            ],
            'activo'       => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no existe.',
            'nombre.required'       => 'El nombre de la subcategoría es obligatorio.',
            'nombre.min'            => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.unique'         => 'Ya existe una subcategoría con ese nombre en esta categoría.',
        ];
    }
}
