<?php

namespace App\Repositories;

use App\Models\factura;
use Illuminate\Support\Facades\DB;


class ServicioRepository
{
    // Pedidos listos para entregar
    public function listarPedidosListos()
    {
        return factura::with([
            'mesa',
            'detalleFactura.producto'
        ])
        ->where('estado', 'Listo')
        ->orderBy('created_at', 'asc')
        ->get();
    }

    // Pedidos completamente entregados
    public function listarPedidosEntregados()
    {
        return factura::with([
            'mesa',
            'detalleFactura.producto'
        ])
        ->where('estado', 'Entregado')
        ->orderBy('created_at', 'asc')
        ->get();
    }

    // Registrar la entrega de una unidad de producto
    public function entregarProducto(int $idFactura, int $idDetalle)
    {
        return DB::transaction(function () use ($idFactura, $idDetalle) {

            $factura = factura::where('id', $idFactura)
                ->lockForUpdate()
                ->firstOrFail();

            if ($factura->estado !== 'Listo') {
                return false;
            }

            $detalle = $factura->detalleFactura()
                ->where('id', $idDetalle)
                ->lockForUpdate()
                ->firstOrFail();

            if ($detalle->cantidadEntregada >= $detalle->cantidad) {
                return false;
            }

            // Entregar una unidad
            $detalle->increment('cantidadEntregada');

            // Comprobar si todos los productos fueron entregados
            $todosEntregados = !$factura->detalleFactura()
                ->whereColumn('cantidadEntregada', '<', 'cantidad')
                ->exists();

            if ($todosEntregados) {
                $factura->update([
                    'estado' => 'Entregado'
                ]);
            }

            return true;
        });
    }


    public function listarPedidosEntregadosPorMesa(int $idMesa)
    {
        return factura::with(['mesa', 'detalleFactura.producto'])
            ->where('idMesa', $idMesa)
            ->where('estado', 'Entregado')
            ->orderBy('created_at', 'asc')
            ->get();
    }


}
