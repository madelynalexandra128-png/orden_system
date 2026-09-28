<?php

namespace App\Services;

use App\Repositories\ProductoRespository;
use Illuminate\Support\Facades\Storage;

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

    public function buscarIdProducto(int $id){
        return $this->productorespository->buscarIdProducto($id);
    }


    public function actualizarProducto(int $id, array $datos)
    {
        $imagen = $datos['imagen'] ?? null;
        unset($datos['imagen']); //no manda la imagen

        if($imagen){

            $producto = $this->productorespository->buscarIdProducto($id);

            if($producto->imagen){
                Storage::disk('public')->delete($producto->imagen);
            }

            $extension = $imagen->getClientOriginalExtension();  #extemsion jpn o png
            $nombreImagen = $producto->id . '.' . $extension;
            $imagen->storeAs( 
                'img', $nombreImagen, 'public'
            );//disco explícito

            $this->productorespository->actualizarProducto($producto->id,['imagen' => 'img/' . $nombreImagen]);

        }
        return $this->productorespository->actualizarProducto($id,$datos);
    }

    public function cambiarEstadoProducto(int $id){
        return $this->productorespository->cambiarEstadoProducto($id);
    }

    public function eliminarProducto(int $id){
        $producto = $this->productorespository->buscarIdProducto($id);

            if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
            }
        return $this->productorespository->eliminarProducto($id);

    }

}
