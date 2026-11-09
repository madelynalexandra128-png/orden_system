<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoriaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
        {
            return [
            'nombre'      => 'required|string|min:3|max:100|',
            'descripcion' => 'required|string|min:5|max:255',
            'estado'      => 'required|boolean',
            ];
        }

    public function messages(): array
        {
        return [
            'nombre.required' => 'El nombre de la categoría es requerido',
            'nombre.string'   => 'El nombre de la categoría debe ser texto',
            'nombre.min'      => 'El nombre de la categoría debe tener mínimo 3 caracteres',
            'nombre.max'      => 'El nombre de la categoría no puede superar 100 caracteres',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre',

            'descripcion.required' => 'La descripción de la categoría es requerida',
            'descripcion.string'   => 'La descripción debe ser texto',
            'descripcion.min'      => 'La descripción debe tener mínimo 5 caracteres',
            'descripcion.max'      => 'La descripción no puede superar 255 caracteres',
        ];
        }
}
