<?php

namespace App\Repositories;

use App\Models\factura;

class FacturaRepository {
    

    public function listarFacturas()
    {
        $facturas = factura::all();
        return $facturas;
    }

    public function guardarFactura(array $datos)
    {
        $productos= $datos['productos'];

        unset($datos['productos']);

        $facturas= factura::create($datos);

        foreach($productos as $datoProducto){
            $facturas->detalleFactura()->create($datoProducto);
        }
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