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

    public function eliminar(int $id){
        categoria::destroy($id);
    }

    public function cambiar(int $id){
        $categoria=categoria::findOrFail($id);

        if($categoria->estado == 1){
            $categoria->estado = 0;
            $mensaje = "categoria desactivada";
        }
        else{
            $categoria->estado = 1;
            $mensaje = "categoria activada";
        }

         $categoria->save(); // save=guardar en ingles 
        return $mensaje;
    }

}