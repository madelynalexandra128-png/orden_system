<?php


namespace App\Services;

use App\Repositories\MesaRepository;

class MesaService{

    private MesaRepository $mesaRepository;

    public function __construct(MesaRepository $mesaRepository) 
    {
        $this->mesaRepository=$mesaRepository;
    }

    public function listarMesas()
    {
        return $this->mesaRepository->listarMesas();
    }

    public function guardarMesas(array $datos)
    {
        return $this->mesaRepository->guardarMesas($datos);
    }

    public function budcarIdMesa(int $id){
        return $this->mesaRepository->budcarIdMesa($id);
    }

    public function actualizarMesa(int $id,array $datos)
    {
        return $this->mesaRepository->actualizarMesa($id,$datos);

    }

    public function eliminarMesa(int $id)
    {
        return $this->mesaRepository->eliminarMesa($id);
    }
}