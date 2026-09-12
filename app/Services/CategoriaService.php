<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService{

    private CategoriaRepository $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository) {
        $this->categoriaRepository = $categoriaRepository;

    }

    public function listar(){
        return $this->categoriaRepository->listar();
    }

    public function guardar(array $datos){
        return $this->categoriaRepository->guardar($datos);
    }

    public function buscarId(int $id){
        return $this->categoriaRepository->buscarId($id);
    }

    public function actualizar(int $id, array $datos){
        return $this->categoriaRepository->actualizar($id,$datos);
    }

    public function eliminar(int $id){
        return $this->categoriaRepository->eliminar($id);
    }

    public function canbiar (int $id ){
        return $this->categoriaRepository->cambiar($id);
    }
}