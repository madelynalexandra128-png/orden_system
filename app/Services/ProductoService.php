<?php

namespace App\Services;

use App\Repositories\ProductoRespository;

class ProductoService{

private ProductoRespository $productorespository;

public function __construct(ProductoRespository $productoRespository) {

    $this->productorespository =$productoRespository;
}


public function listarProductos(){
    return $this->productorespository->listarProductos();
}

public function guardarProducto(array $datos){
    $imagen = $datos['imagen'] ?? null;
    unset($datos['imagen']); //no manda la imagen

    $producto = $this->productorespository->guardarProductos($datos);

    if($imagen){

        $extension = $imagen->getClientOriginalExtension();  #extemsion jpn o png
        $nombreImagen = $producto->id . '.' . $extension;
        $imagen->storeAs( 
            'img', $nombreImagen, 'public'
        );//disco explícito

        $this->productorespository->actualizarProducto($producto->id,['imagen' => 'img/' . $nombreImagen]);
    }

    return $producto;
}



public function actualizarProducto(int $id, array $datos)
{
    return $this->productorespository->actualizarProducto($id,$datos);
}


}
