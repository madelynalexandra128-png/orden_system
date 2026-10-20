<?php

namespace App\Repositories;

use App\Models\factura;

class FacturaRepository {
    

    public function listarFacturas()
    {
        $facturas = factura::all();
        return $facturas;
    }

    public function guardarFactura(array $dados)
    {
        factura::create($dados);
    }

    public function buscasrIdFactura(int $id)
    {
        $facturas= factura::findOrFail($id);
        return $facturas;

    }

    public function actualizarFactura(int $id, array $dados)
    {
        $facturas=factura::findOrFail($id);
        $facturas->update($dados);
        return $facturas;
    }

    public function eliminarFactura(int $id)
    {
        factura::destroy($id);
    }
}