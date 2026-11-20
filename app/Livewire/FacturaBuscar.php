<?php

namespace App\Livewire;

use App\Models\producto;
use Livewire\Component;

class FacturaBuscar extends Component
{
   // Guarda el texto que escribimos en el buscador
    public $buscar = '';

    // Guarda los resultados de la búsqueda
    public $productos = [];

    // Guarda el producto que seleccionamos
    public $productoSeleccionado = null;

    // Guarda la cantidad que queremos agregar
    public $cantidad = 1;

    // Guarda los productos que ya agregamos a la factura
    public $productosFactura = [];

    // Guarda el total de todos los productos
    public $total = 0;

    //total de puntos que gana el cliente 

    public $totalPuntos = 0;


    // ==========================================
    // FUNCIÓN PARA BUSCAR PRODUCTOS
    // ==========================================

    public function render()
    {
        // Inicializamos la lista vacía
        $this->productos = [];

        // Buscamos solamente si hay texto y no hemos seleccionado un producto
        if (trim($this->buscar) != '' && !$this->productoSeleccionado) {

            $this->productos = producto::where(
                'nombre',
                'like',
                '%' . $this->buscar . '%'
            )
                // Mostrar solamente productos activos
                ->where('estado', 1)

                // Mostrar solamente productos con existencias
                ->where('stock', '>', 0)

                // Limitar los resultados a 8 productos
                ->limit(8)

                // Ejecutar la consulta
                ->get();
        }

        // Retornar la vista del componente
        return view('livewire.factura-buscar');
    }


    // ==========================================
    // FUNCIÓN PARA SELECCIONAR UN PRODUCTO
    // ==========================================

    public function seleccionarProducto(int $id)
    {
        // Buscar el producto por su identificador
        $producto = producto::findOrFail($id);

        // Guardar los datos del producto seleccionado
        $this->productoSeleccionado = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'imagen' => $producto->imagen,
            'puntos' => $producto->puntos,
            
        ];

        // Iniciar la cantidad en 1
        $this->cantidad = 1;

        // Mostrar el nombre del producto seleccionado en el buscador
        $this->buscar = $producto->nombre;

        // Enviar un evento para pasar el foco al selector de cantidad
        $this->dispatch('producto-seleccionado');
    }


    // ==========================================
    // FUNCIÓN PARA AGREGAR PRODUCTOS A LA FACTURA
    // ==========================================

    public function agregarProducto()
    {
        // Comprobar que exista un producto seleccionado
        if (!$this->productoSeleccionado) {
            return;
        }

        // Consultar nuevamente el producto en la base de datos
        $producto = producto::findOrFail(
            $this->productoSeleccionado['id']
        );

        // Comprobar que la cantidad sea válida
        if (
            !is_numeric($this->cantidad) ||
            (int) $this->cantidad < 1 ||
            (int) $this->cantidad > $producto->stock
        ) {
            return;
        }

        // Convertir la cantidad a número entero
        $this->cantidad = (int) $this->cantidad;

        // Obtener el identificador del producto
        $id = $producto->id;


        // Comprobar si el producto ya está en la factura
        if (isset($this->productosFactura[$id])) {

            // Sumar la cantidad nueva con la que ya existe
            $nuevaCantidad =
                $this->productosFactura[$id]['cantidad'] + $this->cantidad;

            // Comprobar que no supere el stock disponible
            if ($nuevaCantidad > $producto->stock) {
                return;
            }

            // Actualizar la cantidad del producto
            $this->productosFactura[$id]['cantidad'] = $nuevaCantidad;

            // Calcular nuevamente el subtotal
            $this->productosFactura[$id]['total'] =
                $nuevaCantidad * $producto->precio;

            $this->productosFactura[$id]['puntos'] =
                $nuevaCantidad * $producto->puntos;

        } else {

            // Si el producto no existe, agregarlo a la factura
        $this->productosFactura[$id] = [
            'idProducto' => $producto->id,
            'nombre' => $producto->nombre,
            'precioUnitario' => $producto->precio,
            'cantidad' => $this->cantidad,
            'total' => $this->cantidad * $producto->precio,
            'imagen' => $producto->imagen,
            'puntos' => $this->cantidad * $producto->puntos,
        ];
        }

        // Actualizar los cálculos después de agregar el producto
        $this->calcularTotal();
        $this->calcularPuntos();

        // Limpiar el producto seleccionado
        $this->productoSeleccionado = null;

        // Restablecer la cantidad
        $this->cantidad = 1;

        // Limpiar el buscador para buscar otro producto
        $this->buscar = '';
    }


    // ==========================================
    // FUNCIÓN PARA ELIMINAR UN PRODUCTO
    // ==========================================

    public function eliminarProducto(int $id)
    {
        // Eliminar el producto de la lista 
        unset($this->productosFactura[$id]);

        $this->calcularTotal();
        $this->calcularPuntos();
    }


    // ==========================================
    // FUNCIÓN PARA VACIAR TODA LA LISTA
    // ==========================================

    public function vaciarLista()
    {
        // vaciar la lista
        $this->productosFactura = [];

        $this->calcularTotal();
        $this->calcularPuntos();
    }

    public function calcularTotal()
    {
        //suma todo los subtotales del producto 
        $this->total = collect($this->productosFactura)->sum('total');

        // Enviar el total actualizado al formulario principal
        $this->dispatch('total-actualizado', total: $this->total);
    }


    public function calcularPuntos()
    {
        // Suma los puntos de todos los productos agregados
        $this->totalPuntos = collect($this->productosFactura)->sum('puntos');

        $this->dispatch('puntos-actualizados', puntos: $this->totalPuntos);
    }

}


