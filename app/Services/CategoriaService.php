<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService{

    private CategoriaRepository $categoria_repository;

    public function __construct(CategoriaRepository $categoriaRepository) {
        $this->categoria_repository = $categoriaRepository;
        
    }
}