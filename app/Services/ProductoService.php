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



}
