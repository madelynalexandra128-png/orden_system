<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class GuardarFacturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos generales de la factura
            'idCliente' => ['required', 'integer', 'exists:cliente,id'],
            'idMesa' => ['required', 'integer', 'exists:mesa,id'],

            'metodoPago' => [
                'required',
                Rule::in(['Efectivo', 'Tarjeta', 'Transferencia', 'Mixto'])
            ],

            'estado' => [
                'required',
                Rule::in(['pendiente', 'pagada', 'anulada'])
            ],

            // Productos de la factura
            'productos' => ['required', 'array', 'min:1'],

            'productos.*.idProducto' => [
                'required',
                'integer',
                'distinct',
                'exists:producto,id'
            ],

            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1'
            ],

            'productos.*.precioUnitario' => [
                'required',
                'numeric',
                'min:0'
            ],

            'productos.*.total' => [
                'required',
                'numeric',
                'min:0'
            ],

            // Pago en efectivo
            'montoRecibido' => [
                Rule::requiredIf(fn () =>
                    in_array($this->metodoPago, ['Efectivo', 'Mixto'])
                ),
                'nullable',
                'numeric',
                'min:0'
            ],

            // Pago con tarjeta
            'montoTarjeta' => [
                Rule::requiredIf(fn () =>
                    $this->metodoPago === 'Mixto'
                    && $this->metodoMixto === 'Tarjeta'
                ),
                'nullable',
                'numeric',
                'min:0'
            ],

            // Pago por transferencia
            'montoTransferencia' => [
                Rule::requiredIf(fn () =>
                    $this->metodoPago === 'Mixto'
                    && $this->metodoMixto === 'Transferencia'
                ),
                'nullable',
                'numeric',
                'min:0'
            ],

            // Segundo método cuando el pago es mixto
            'metodoMixto' => [
                'required_if:metodoPago,Mixto',
                'nullable',
                Rule::in(['Tarjeta', 'Transferencia'])
            ],

            // Total de la factura
            'total' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            // Cliente
            'idCliente.required' => 'Debes seleccionar un cliente.',
            'idCliente.exists' => 'El cliente seleccionado no existe.',

            // Mesa
            'idMesa.required' => 'Debes seleccionar una mesa.',
            'idMesa.exists' => 'La mesa seleccionada no existe.',

            // Método de pago
            'metodoPago.required' => 'Debes seleccionar un método de pago.',
            'metodoPago.in' => 'El método de pago no es válido.',

            // Estado
            'estado.required' => 'Debes seleccionar un estado.',
            'estado.in' => 'El estado seleccionado no es válido.',

            // Productos
            'productos.required' => 'Debes agregar productos a la factura.',
            'productos.min' => 'Debes agregar al menos un producto.',

            'productos.*.idProducto.required' => 'Debes seleccionar un producto.',
            'productos.*.idProducto.exists' => 'Uno de los productos no existe.',
            'productos.*.idProducto.distinct' => 'Hay productos repetidos.',

            'productos.*.cantidad.required' => 'Debes indicar la cantidad.',
            'productos.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad debe ser mayor que cero.',

            // Pagos
            'montoRecibido.required' => 'Debes ingresar el monto recibido en efectivo.',
            'montoRecibido.numeric' => 'El efectivo debe ser un número.',
            'montoRecibido.min' => 'El efectivo no puede ser negativo.',

            'montoTarjeta.required' => 'Debes ingresar el monto pagado con tarjeta.',
            'montoTarjeta.numeric' => 'El monto de tarjeta debe ser un número.',

            'montoTransferencia.required' => 'Debes ingresar el monto transferido.',
            'montoTransferencia.numeric' => 'El monto de transferencia debe ser un número.',

            'metodoMixto.required_if' => 'Debes seleccionar el segundo método de pago.',
            'metodoMixto.in' => 'El segundo método debe ser tarjeta o transferencia.',

            // Total
            'total.required' => 'El total de la factura es obligatorio.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser negativo.',
        ];
    }
}