<?php

namespace App\Repositories;
use App\Models\categoria;

class CategoriaRepository{

    public function listar(){
        $categotias = categoria::all();
        return $categotias;
    }

    public function guardar(array $datos){
        categoria::create($datos);
    }

}