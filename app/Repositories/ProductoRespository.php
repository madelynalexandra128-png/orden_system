<?php
namespace App\Repositories;

use App\Models\producto;

class ProductoRespository{


    public function listarProductos(){
        return producto::all();
    }




}