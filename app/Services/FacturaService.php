<?php

namespace App\Services;

use App\Repositories\FacturaRepository;

class FacturaService{

    private FacturaRepository $facturaRepository;

    public function __construct(FacturaRepository $facturaRepository) 
    {
        return $this->facturaRepository=$facturaRepository;
    }

    public function listarFacturas()
    {
        return $this->facturaRepository->listarFacturas();
    }

    public function guardarFactura(array $datos)
    {
        return $this->facturaRepository->guardarFactura($datos);
    }

    public function buscasrIdFactura(int $id)
    {
        return $this->facturaRepository->buscasrIdFactura($id);
    }

    public function actualizarFactura(int $id,array $datos)
    {
        return $this->facturaRepository->actualizarFactura($id,$datos);
    }

    public function eliminarFactura(int $id)
    {
        return $this->facturaRepository->eliminarFactura($id);
    }
}