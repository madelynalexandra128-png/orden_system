<?php
namespace App\Repositories;

use App\Models\producto;

class ProductoRespository{


    public function listarProductos(){
        return producto::all();
    }

    public function guardarProductos(array $datos){
        return  producto::create($datos);
    }

    


    public function actualizarProducto(int $id, array $datos)
    {
        $productos=producto::findOrFail ($id);
        $productos->update($datos);
        return $productos;
    }




}