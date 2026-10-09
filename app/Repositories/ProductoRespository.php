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

    public function buscarIdProducto(int $id){
        $productos=producto::findOrFail ($id);
        return $productos;
    }


    public function actualizarProducto(int $id, array $datos)
    {
        $productos=producto::findOrFail ($id);
        $productos->update($datos);
        return $productos;
    }

    public function cambiarEstadoProducto(int $id){
        $productos=producto::findOrFail ($id);
        if($productos->estado == 1){
            $productos->estado = 0;
            $mensaje = "Producto desactivado";
        }else{
            $productos->estado = 1;
            $mensaje = "Producto Activado";
        }
        $productos->save();
        return $mensaje;
    }


    public function eliminarProducto(int $id){
        producto::destroy($id);
    }
}




