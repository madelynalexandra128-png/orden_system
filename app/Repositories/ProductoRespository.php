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

    public function cambiarEstadoProducto(int $id)
    {
        $productos = producto::with('categoria')->findOrFail($id);

        // Si está activo, permitir desactivarlo
        if ($productos->estado == 1) {
            $productos->estado = false;
            $mensaje = "Producto desactivado";
        } else {

            // Comprobar las existencias
            if ($productos->stock <= 5) {
                return "No se puede activar: el stock debe ser mayor a 5.";
            }

            // Comprobar el estado de la categoría
            if (!$productos->categoria || $productos->categoria->estado == 0) {
                return "No se puede activar: la categoría está inactiva.";
            }

            $productos->estado = true;
            $mensaje = "Producto activado";
        }

        $productos->save();

        return $mensaje;
    }


    public function contarActivo(){
        return producto::where('estado',true)->count();
    }

    public function listarProductosDisponibles()
    {
        return producto::with('categoria')
            ->where('estado', 1)
            ->where('stock', '>', 0)
            ->get();
    }

    
    public function agregarStock(int $id, int $cantidad)
    {
        $producto = producto::findOrFail($id);

        // Aumentar las existencias
        $producto->increment('stock', $cantidad);

        // Actualizar los datos del producto
        $producto->refresh();

        // Consultar si la categoría está activa
        $categoriaActiva = $producto->categoria()->value('estado');

        // Actualizar el estado del producto
        $producto->update([
            'estado' => $producto->stock > 5 && (bool) $categoriaActiva
        ]);

        return $producto;
    }

    public function eliminarProducto(int $id)
    {
        $producto = producto::findOrFail($id);

        return $producto->delete();
    }
}




