<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService{

    private CategoriaRepository $categoria_repository;

    public function __construct(CategoriaRepository $categoriaRepository) {
        $this->categoria_repository = $categoriaRepository;

    }

    public function listar(){
        return $this->categoria_repository->listar();
    }

    public function guardar(array $datos){
        $this->categoria_repository->guardar($datos);
    }
}