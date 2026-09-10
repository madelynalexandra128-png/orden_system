<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService{

    private CategoriaRepository $categoriarepository;

    public function __construct(CategoriaRepository $categoriaRepository) {
        $this->categoriarepository = $categoriaRepository;

    }

    public function listar(){
        return $this->categoriarepository->listar();
    }

    public function guardar(array $datos){
        return $this->categoriarepository->guardar($datos);
    }

    public function buscarId(int $id){
        return $this->categoriarepository->buscarId($id);
    }

    public function actualizar(int $id, array $datos){
        return $this->categoriarepository->actualizar($id,$datos);
    }

    public function eliminar(int $id){
        return $this->categoriarepository->eliminar($id);
    }

    public function canbiar (int $id ){
        return $this->categoriarepository->cambiar($id);
    }
}