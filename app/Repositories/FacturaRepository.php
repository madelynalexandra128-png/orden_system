<?php

namespace App\Repositories;

use App\Models\factura;
use App\Models\mesa;
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



    public function registrarPago(int $idFactura, array $datos)
    {
        return DB::transaction(function () use ($idFactura, $datos) {

            $factura = factura::where('id', $idFactura)
                ->lockForUpdate()
                ->firstOrFail();

            // Solo se pueden pagar facturas entregadas
            if ($factura->estado !== 'Entregado') {
                throw ValidationException::withMessages([
                    'pago' => 'Esta orden no está disponible para pagar.'
                ]);
            }

            $total = round((float) $factura->total, 2);

            $metodoPago = $datos['metodoPago'] ?? '';

            $montoEfectivo = 0;
            $montoTarjeta = 0;
            $montoTransferencia = 0;

            // Pago en efectivo
            if ($metodoPago === 'Efectivo') {

                $recibido = (float) ($datos['montoRecibido'] ?? 0);

                if ($recibido < $total) {
                    throw ValidationException::withMessages([
                        'montoRecibido' => 'El efectivo recibido no cubre el total.'
                    ]);
                }

                $montoEfectivo = $total;

            // Pago con tarjeta
            } elseif ($metodoPago === 'Tarjeta') {

                $montoTarjeta = $total;

            // Pago por transferencia
            } elseif ($metodoPago === 'Transferencia') {

                $montoTransferencia = $total;

            // Pago mixto
            } elseif ($metodoPago === 'Mixto') {

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

                if (
                    round($totalPagado, 2) !== $total ||
                    min($montoEfectivo, $montoTarjeta, $montoTransferencia) < 0
                ) {
                    throw ValidationException::withMessages([
                        'metodoPago' => 'Los pagos deben completar exactamente el total.'
                    ]);
                }

            } else {

                throw ValidationException::withMessages([
                    'metodoPago' => 'El método de pago no es válido.'
                ]);
            }

            // Registrar el pago sin crear otra factura
            $factura->update([
                'metodoPago' => $metodoPago,
                'estado' => 'Facturado',
                'montoEfectivo' => $montoEfectivo,
                'montoTarjeta' => $montoTarjeta,
                'montoTransferencia' => $montoTransferencia
            ]);

            $this->liberarMesaSiNoTienePedidosActivos((int) $factura->idMesa);

            return $factura;
        });
    }



    public function registrarPagoMesa(int $idMesa, array $datos)
    {
        return DB::transaction(function () use ($idMesa, $datos) {

            // Buscar y bloquear las órdenes entregadas de la mesa
            $facturas = factura::where('idMesa', $idMesa)
                ->where('estado', 'Entregado')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($facturas->isEmpty()) {
                throw ValidationException::withMessages([
                    'pago' => 'No hay órdenes entregadas pendientes de pago.'
                ]);
            }

            // Calcular el total de todas las facturas
            $total = round((float) $facturas->sum('total'), 2);

            $metodoPago = $datos['metodoPago'] ?? '';

            $efectivo = 0;
            $tarjeta = 0;
            $transferencia = 0;

            // Validar el método de pago
            if ($metodoPago === 'Efectivo') {

                $recibido = round(
                    (float) ($datos['montoRecibido'] ?? 0),
                    2
                );

                if ($recibido < $total) {
                    throw ValidationException::withMessages([
                        'pago' => 'El efectivo recibido no cubre el total de la mesa.'
                    ]);
                }

                $efectivo = $total;

            } elseif ($metodoPago === 'Tarjeta') {

                $tarjeta = $total;

            } elseif ($metodoPago === 'Transferencia') {

                $transferencia = $total;

            } elseif ($metodoPago === 'Mixto') {

                $efectivo = round(
                    (float) ($datos['montoRecibido'] ?? 0),
                    2
                );

                $metodoMixto = $datos['metodoMixto'] ?? '';

                if ($efectivo < 0 || $efectivo > $total) {
                    throw ValidationException::withMessages([
                        'pago' => 'El valor en efectivo no es válido.'
                    ]);
                }

                if ($metodoMixto === 'Tarjeta') {

                    $tarjeta = round(
                        (float) ($datos['montoTarjeta'] ?? 0),
                        2
                    );

                } elseif ($metodoMixto === 'Transferencia') {

                    $transferencia = round(
                        (float) ($datos['montoTransferencia'] ?? 0),
                        2
                    );

                } else {

                    throw ValidationException::withMessages([
                        'pago' => 'Selecciona un segundo método de pago válido.'
                    ]);
                }

                if ($tarjeta < 0 || $transferencia < 0) {
                    throw ValidationException::withMessages([
                        'pago' => 'Los valores no pueden ser negativos.'
                    ]);
                }

                $suma = round($efectivo + $tarjeta + $transferencia, 2);

                if ($suma !== $total) {
                    throw ValidationException::withMessages([
                        'pago' => 'La suma de los métodos debe coincidir con el total de la mesa.'
                    ]);
                }

            } else {

                throw ValidationException::withMessages([
                    'pago' => 'Selecciona un método de pago válido.'
                ]);
            }

            // Distribuir los valores entre las facturas
            $efectivoRestante = $efectivo;
            $tarjetaRestante = $tarjeta;
            $transferenciaRestante = $transferencia;

            foreach ($facturas as $factura) {

                $totalFactura = round((float) $factura->total, 2);

                $montoEfectivo = min(
                    $totalFactura,
                    $efectivoRestante
                );

                $efectivoRestante = round(
                    $efectivoRestante - $montoEfectivo,
                    2
                );

                $restanteFactura = round(
                    $totalFactura - $montoEfectivo,
                    2
                );

                $montoTarjeta = min(
                    $restanteFactura,
                    $tarjetaRestante
                );

                $tarjetaRestante = round(
                    $tarjetaRestante - $montoTarjeta,
                    2
                );

                $restanteFactura = round(
                    $restanteFactura - $montoTarjeta,
                    2
                );

                $montoTransferencia = min(
                    $restanteFactura,
                    $transferenciaRestante
                );

                $transferenciaRestante = round(
                    $transferenciaRestante - $montoTransferencia,
                    2
                );

                // Guardar el pago de cada factura
                $factura->update([
                    'metodoPago' => $metodoPago,
                    'estado' => 'Facturado',
                    'montoEfectivo' => $montoEfectivo,
                    'montoTarjeta' => $montoTarjeta,
                    'montoTransferencia' => $montoTransferencia,
                ]);
            }

            $this->liberarMesaSiNoTienePedidosActivos($idMesa);


            return true;
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


    private function liberarMesaSiNoTienePedidosActivos(int $idMesa)
    {
        $pedidosActivos = factura::where('idMesa', $idMesa)
            ->where('estado', '!=', 'Facturado')
            ->exists();

        if (!$pedidosActivos) {
            mesa::where('id', $idMesa)
                ->update(['estado' => 'Disponible']);
        }
    }
}