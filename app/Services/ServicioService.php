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

    public function listarPedidosListos()
    {
        return $this->servicioRepository->listarPedidosListos();
    }

    public function listarPedidosEntregados()
    {
        return $this->servicioRepository->listarPedidosEntregados();
    }

    public function entregarProducto(int $idFactura, int $idDetalle)
    {
        return $this->servicioRepository->entregarProducto(
            $idFactura,
            $idDetalle
        );
    }


    public function listarPedidosEntregadosPorMesa(int $idMesa)
    {
        return $this->servicioRepository->listarPedidosEntregadosPorMesa($idMesa);
    }

}
