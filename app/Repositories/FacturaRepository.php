<?php

namespace App\Repositories;

use App\Models\factura;
use App\Models\producto;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FacturaRepository {
    

    public function listarFacturas()
    {
        $facturas = factura::all();
        return $facturas;
    }

    public function guardarFactura(array $datos)
    {
        return DB::transaction(function () use ($datos) {

            // Obtener los productos enviados desde el formulario
            $productos = $datos['productos'] ?? [];

            if (empty($productos)) {
                throw ValidationException::withMessages([
                    'productos' => 'Debes agregar al menos un producto.'
                ]);
            }

            // Preparar los detalles y calcular el total real
            $total = 0;
            $detalles = [];

            foreach ($productos as $datoProducto) {

                $producto = producto::whereKey($datoProducto['idProducto'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $cantidad = (int) $datoProducto['cantidad'];

                if ($cantidad < 1) {
                    throw ValidationException::withMessages([
                        'productos' => 'La cantidad debe ser mayor que cero.'
                    ]);
                }

                // Comprobar las existencias
                if ($producto->stock < $cantidad) {
                    throw ValidationException::withMessages([
                        'productos' => "No hay suficiente stock de {$producto->nombre}."
                    ]);
                }

                // Utilizar el precio guardado en la base de datos
                $precioUnitario = (float) $producto->precio;

                $subtotal = round($precioUnitario * $cantidad, 2);

                $total += $subtotal;

                $detalles[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'precioUnitario' => $precioUnitario,
                    'total' => $subtotal
                ];
            }

            $total = round($total, 2);

            // Inicializar los valores de los pagos
            $montoEfectivo = 0;
            $montoTarjeta = 0;
            $montoTransferencia = 0;

            // Determinar los valores según el método de pago
            if ($datos['metodoPago'] === 'Efectivo') {

                $recibido = (float) ($datos['montoRecibido'] ?? 0);

                if ($recibido < $total) {
                    throw ValidationException::withMessages([
                        'montoRecibido' => 'El efectivo recibido no cubre el total.'
                    ]);
                }

                $montoEfectivo = $total;

            } elseif ($datos['metodoPago'] === 'Tarjeta') {

                $montoTarjeta = $total;

            } elseif ($datos['metodoPago'] === 'Transferencia') {

                $montoTransferencia = $total;

            } elseif ($datos['metodoPago'] === 'Mixto') {

                $montoEfectivo = (float) ($datos['montoRecibido'] ?? 0);

                if (($datos['metodoMixto'] ?? '') === 'Tarjeta') {

                    $montoTarjeta = (float) ($datos['montoTarjeta'] ?? 0);

                } elseif (($datos['metodoMixto'] ?? '') === 'Transferencia') {

                    $montoTransferencia = (float) ($datos['montoTransferencia'] ?? 0);

                } else {

                    throw ValidationException::withMessages([
                        'metodoMixto' => 'Selecciona un segundo método de pago válido.'
                    ]);
                }

                $totalPagado = $montoEfectivo
                    + $montoTarjeta
                    + $montoTransferencia;

                if (round($totalPagado, 2) !== $total) {
                    throw ValidationException::withMessages([
                        'metodoPago' => 'Los pagos deben completar el total de la factura.'
                    ]);
                }

            } else {

                throw ValidationException::withMessages([
                    'metodoPago' => 'El método de pago no es válido.'
                ]);
            }

            // Crear la factura
            $factura = factura::create([
                'idCliente' => $datos['idCliente'],
                'idMesa' => $datos['idMesa'],
                'metodoPago' => $datos['metodoPago'],
                'estado' => $datos['estado'],
                'fecha' => now()->toDateString(),
                'total' => $total,
                'montoEfectivo' => $montoEfectivo,
                'montoTarjeta' => $montoTarjeta,
                'montoTransferencia' => $montoTransferencia
            ]);

            // Guardar los detalles y descontar el inventario
            foreach ($detalles as $detalle) {

                $factura->detalleFactura()->create([
                    'idProducto' => $detalle['producto']->id,
                    'cantidad' => $detalle['cantidad'],
                    'precioUnitario' => $detalle['precioUnitario'],
                    'total' => $detalle['total']
                ]);

                $detalle['producto']->decrement(
                    'stock',
                    $detalle['cantidad']
                );
            }

            return $factura;
        });
    
    }




public function guardarPedidoPendiente(array $datos)
{
    return DB::transaction(function () use ($datos) {

        $productos = $datos['productos'] ?? [];

        if (empty($productos)) {
            throw ValidationException::withMessages([
                'productos' => 'Debes agregar al menos un producto.'
            ]);
        }

        $total = 0;
        $detalles = [];

        foreach ($productos as $datoProducto) {

            $producto = producto::whereKey($datoProducto['idProducto'])
                ->lockForUpdate()
                ->firstOrFail();

            $cantidad = (int) $datoProducto['cantidad'];

            if ($cantidad < 1) {
                throw ValidationException::withMessages([
                    'productos' => 'La cantidad debe ser mayor que cero.'
                ]);
            }

            if (!$producto->estado || $producto->stock < $cantidad) {
                throw ValidationException::withMessages([
                    'productos' => "No hay suficientes existencias de {$producto->nombre}."
                ]);
            }

            $precioUnitario = (float) $producto->precio;
            $subtotal = round($precioUnitario * $cantidad, 2);

            $total += $subtotal;

            $detalles[] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'precioUnitario' => $precioUnitario,
                'total' => $subtotal
            ];
        }

        $total = round($total, 2);

        // Crear factura pendiente
        $factura = factura::create([
            'idCliente' => $datos['idCliente'] ?? null,
            'idMesa' => $datos['idMesa'],
            'metodoPago' => null,
            'estado' => 'Pendiente',
            'fecha' => now()->toDateString(),
            'total' => $total,
            'montoEfectivo' => 0,
            'montoTarjeta' => 0,
            'montoTransferencia' => 0
        ]);

        // Guardar detalles y descontar inventario
        foreach ($detalles as $detalle) {

            $factura->detalleFactura()->create([
                'idProducto' => $detalle['producto']->id,
                'cantidad' => $detalle['cantidad'],
                'precioUnitario' => $detalle['precioUnitario'],
                'total' => $detalle['total']
            ]);

            $detalle['producto']->decrement(
                'stock',
                $detalle['cantidad']
            );
        }

        return $factura;
    });
}


    public function buscasrIdFactura(int $id)
    {
        $facturas= factura::findOrFail($id);
        return $facturas;

    }

    public function actualizarFactura(int $id, array $datos)
    {
        $facturas=factura::findOrFail($id);
        $facturas->update($datos);
        return $facturas;
    }

    public function eliminarFactura(int $id)
    {
        factura::destroy($id);
    }


    
}