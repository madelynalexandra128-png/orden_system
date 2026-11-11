<?php

namespace App\Repositories;

use App\Models\factura;

class ServicioRepository
{
    // Listar los pedidos que están listos para entregar
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

    // Pedidos que ya fueron entregados y esperan el pago
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

    // Marcar pedido como entregado
    public function cambiarAEntregado(int $idFactura)
    {
        $factura = factura::findOrFail($idFactura);

        if ($factura->estado !== 'Listo') {
            return false;
        }

        $factura->update([
            'estado' => 'Entregado'
        ]);

        return true;
    }
}
