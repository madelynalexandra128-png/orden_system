<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductoUpdateRequest extends FormRequest
{
    public function authorize(): bool
{
    return true;
}

public function rules(): array
{

    return [
        'nombre'       => 'required|string|min:3|max:100|' ,
        'descripcion'  => 'nullable|string|min:5|max:255',
        'precio'       => 'required|numeric|min:0|gt:precioCompra',
        'precioCompra' => 'required|numeric|min:0',
        'stock'        => 'required|integer|min:0',
        'puntos'       => 'required|integer|min:0',
        'imagen'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'idCategoria'  => 'required|integer|exists:categoria,id',
    ];
}

public function messages(): array
{
    return [
        'nombre.required' => 'El nombre del producto es requerido',
        'nombre.string'   => 'El nombre del producto debe ser texto',
        'nombre.min'      => 'El nombre del producto debe tener mínimo 3 caracteres',
        'nombre.max'      => 'El nombre del producto no puede superar 100 caracteres',
        'nombre.unique'   => 'Ya existe otro producto con ese nombre',

        'descripcion.required' => 'La descripción del producto es requerida',
        'descripcion.string'   => 'La descripción debe ser texto',
        'descripcion.min'      => 'La descripción debe tener mínimo 5 caracteres',
        'descripcion.max'      => 'La descripción no puede superar 255 caracteres',

        'precio.required' => 'El precio de venta es requerido',
        'precio.numeric'  => 'El precio de venta debe ser un número',
        'precio.min'      => 'El precio de venta no puede ser negativo',
        'precio.gt'       => 'El precio de venta debe ser mayor al precio de compra',

        'precioCompra.required' => 'El precio de compra es requerido',
        'precioCompra.numeric'  => 'El precio de compra debe ser un número',
        'precioCompra.min'      => 'El precio de compra no puede ser negativo',

        'stock.required' => 'El stock es requerido',
        'stock.integer'  => 'El stock debe ser un número entero',
        'stock.min'      => 'El stock no puede ser negativo',


        'puntos.required' => 'Los puntos son requeridos',
        'puntos.integer'  => 'Los puntos deben ser un número entero',
        'puntos.min'      => 'Los puntos no pueden ser negativos',

        'imagen.image' => 'El archivo debe ser una imagen',
        'imagen.mimes' => 'La imagen debe ser jpg, jpeg, png o webp',
        'imagen.max'   => 'La imagen no puede pesar más de 2 MB',

        'idCategoria.required' => 'La categoría es requerida',
        'idCategoria.integer'  => 'La categoría no es válida',
        'idCategoria.exists'   => 'La categoría seleccionada no existe',
    ];
}
}
