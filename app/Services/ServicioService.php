<?php

namespace App\Services;

use App\Repositories\ServicioRepository;

class ServicioService
{
    private ServicioRepository $servicioRepository;

    public function __construct(ServicioRepository $servicioRepository)
    {
        $this->servicioRepository = $servicioRepository;
    }

    // Consultar los pedidos
    public function listarPedidosListos()
    {
        return $this->servicioRepository->listarPedidosListos();
    }

    public function listarPedidosEntregados()
    {
        return $this->servicioRepository->listarPedidosEntregados();
    }

    public function cambiarAEntregado(int $idFactura)
    {
        return $this->servicioRepository->cambiarAEntregado($idFactura);
    }
}
