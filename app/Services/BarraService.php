<?php

namespace App\Services;

use App\Repositories\BarraRepository;

class BarraService
{
    private BarraRepository $barraRepository;

    public function __construct(BarraRepository $barraRepository)
    {
        $this->barraRepository = $barraRepository;
    }

    public function listarPedidos()
    {
        return $this->barraRepository->listarPedidos();
    }

    public function cambiarAEnPreparacion(int $idFactura)
    {
        return $this->barraRepository->cambiarAEnPreparacion($idFactura);
    }

    public function cambiarAListo(int $idFactura)
    {
        return $this->barraRepository->cambiarAListo($idFactura);
    }
}
