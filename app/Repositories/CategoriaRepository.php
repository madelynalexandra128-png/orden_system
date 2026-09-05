<?php

namespace App\Repositories;
use App\Models\categoria;

class CategoriaRepository{

    public function listar(){
        return categoria::all();
    }

    public function guardar(array $datos){
        categoria::create($datos);
    }

    public function buscarId(int $id){
        $categorias=categoria::findOrFail($id);
        return $categorias;
    }

    public function actualizar(int $id,array $datos){
        $categorias=categoria::findOrFail($id);
        $categorias->update($datos);
    }

}