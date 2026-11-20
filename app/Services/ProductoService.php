<?php

namespace App\Services;

use App\Repositories\ProductoRespository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProductoService{

    private ProductoRespository $productorespository;
    private CategoriaService $categoriaservice;

    public function __construct(ProductoRespository $productoRespository, CategoriaService $categoriaservice) {

        $this->productorespository =$productoRespository;
        $this->categoriaservice= $categoriaservice;
    }


    public function listarProductos(){
        return $this->productorespository->listarProductos();
    }

    public function guardarProducto(array $datos){
        $imagen = $datos['imagen'] ?? null;
        unset($datos['imagen']); //no manda la imagen

        $datos['estado'] = $this->estado($datos['stock'], $datos['idCategoria']);
        $producto = $this->productorespository->guardarProductos($datos);

        if($imagen){

            $extension = $imagen->extension();  #extemsion jpn o png
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

            $extension = $imagen->extension();  #extemsion jpn o png
            $nombreImagen = $producto->id . '.' . $extension;
            $imagen->storeAs( 
                'img', $nombreImagen, 'public'
            );//disco explícito

            $this->productorespository->actualizarProducto($producto->id,['imagen' => 'img/' . $nombreImagen]);

        }
        $datos['estado'] = $this->estado($datos['stock'], $datos['idCategoria']);
        return $this->productorespository->actualizarProducto($id,$datos);
    }

    public function cambiarEstadoProducto(int $id){
        return $this->productorespository->cambiarEstadoProducto($id);
    }


    public function contarActivo(){
        return $this->productorespository->contarActivo();
    }


    private function estado(int $stock, int $idCategoria): bool
    {
        $categoria = $this->categoriaservice->buscarId($idCategoria);

        if ($categoria->estado == 0) {
            return false;
        }

        if ($stock <= 0) {
            return false;
        }

        return true;
    }

    public function listarProductosDisponibles()
    {
        return $this->productorespository->listarProductosDisponibles();
    }

    public function agregarStock(int $id, int $cantidad)
    {
        if ($cantidad <= 0) {
            throw new \InvalidArgumentException(
                'La cantidad debe ser mayor que cero.'
            );
        }

        return $this->productorespository->agregarStock($id, $cantidad);
    }

    public function eliminarProducto(int $id)
    {
        $producto = $this->productorespository->buscarIdProducto($id);

        try {

            $this->productorespository->eliminarProducto($id);

            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            return true;

        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                return false;
            }

            throw $e;
        }
    }
}
