<?php

namespace App\Repositories;

use App\Models\factura;

class BarraRepository
{
    public function listarPedidos()
    {
        return factura::with([
            'mesa',
            'detalleFactura.producto'
        ])
        ->whereIn('estado', [
            'Pendiente',
            'En preparación',
            'Listo'
        ])
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function cambiarAEnPreparacion(int $idFactura)
    {
        $factura = factura::findOrFail($idFactura);

        if ($factura->estado !== 'Pendiente') {
            return false;
        }

        $factura->update([
            'estado' => 'En preparación'
        ]);

        return true;
    }

    public function cambiarAListo(int $idFactura)
    {
        $factura = factura::findOrFail($idFactura);

        if ($factura->estado !== 'En preparación') {
            return false;
        }

        $factura->update([
            'estado' => 'Listo'
        ]);

        return true;
    }
}
