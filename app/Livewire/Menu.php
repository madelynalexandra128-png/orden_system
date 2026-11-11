<?php

namespace App\Livewire;

use App\Models\AccesoQr;
use App\Services\FacturaService;
use App\Services\MenuQrService;
use Livewire\Component;

class Menu extends Component
{
    public $mesa;
    public $productos;
    public $categorias;

    public $pedidoConfirmado = null;

    public $categoriaSeleccionada = null;
    public $buscar = '';

    // Productos agregados al pedido
    public $pedido = [];

    // Mostrar u ocultar el resumen
    public $mostrarResumen = false;

    public function mount(string $codigoQr)
    {
        $menuQrService = app(MenuQrService::class);

        $datos = $menuQrService->mostrarMenu($codigoQr);

        $this->mesa = $datos['mesa'];
        $this->productos = $datos['productos'];
        $this->categorias = $datos['categorias'];
    }

    public function seleccionarCategoria($idCategoria = null)
    {
        $this->categoriaSeleccionada = $idCategoria;
    }

    // Agregar un producto al pedido
    public function agregarProducto(int $idProducto)
    {
        $producto = $this->productos->firstWhere('id', $idProducto);

        if (!$producto || !$producto->estado || $producto->stock < 1) {
            $this->addError('pedido', 'Este producto no está disponible.');
            return;
        }

        $cantidadActual = $this->pedido[$idProducto]['cantidad'] ?? 0;

        if ($cantidadActual >= $producto->stock) {
            $this->addError('pedido', 'No hay más existencias de este producto.');
            return;
        }

        $this->resetValidation('pedido');

        if (isset($this->pedido[$idProducto])) {

            $this->pedido[$idProducto]['cantidad']++;

        } else {

            $this->pedido[$idProducto] = [
                'idProducto' => $producto->id,
                'nombre' => $producto->nombre,
                'imagen' => $producto->imagen,
                'precio' => $producto->precio,
                'cantidad' => 1
            ];
        }
    }

    // Eliminar un producto del pedido
    public function eliminarProducto(int $idProducto)
    {
        unset($this->pedido[$idProducto]);
    }

    // Abrir el resumen del pedido
    public function verPedido()
    {
        if (empty($this->pedido)) {
            $this->addError('pedido', 'Primero debes agregar algún producto.');
            return;
        }

        $this->mostrarResumen = true;
    }

    // Regresar al menú
    public function volverAlMenu()
    {
        $this->mostrarResumen = false;
    }

    public function enviarPedido()
    {
        if (empty($this->pedido)) {
            $this->addError('pedido', 'Debes agregar productos antes de enviar.');
            return;
        }

        $facturaService = app(FacturaService::class);

        $factura = $facturaService->guardarPedidoPendiente([
            'idCliente' => null,
            'idMesa' => $this->mesa->id,
            'productos' => array_values($this->pedido)
        ]);

        // Obtener los detalles de la factura
        $factura->load('detalleFactura.producto');

        // Preparar la información para mostrar la confirmación
        $this->pedidoConfirmado = [
            'numero' => $factura->id,
            'estado' => $factura->estado,
            'total' => $factura->total,

            'productos' => $factura->detalleFactura->map(function ($detalle) {
                return [
                    'nombre' => $detalle->producto?->nombre ?? 'Producto',
                    'imagen' => $detalle->producto?->imagen,
                    'cantidad' => $detalle->cantidad,
                    'precio' => $detalle->precioUnitario,
                    'subtotal' => $detalle->total
                ];
            })->toArray()
        ];

        // Actualizar el acceso QR
        $token = session('token_qr_mesa_' . $this->mesa->id);

        if ($token) {
            AccesoQr::where('token', $token)
                ->where('idMesa', $this->mesa->id)
                ->update([
                    'estado' => 'pedido',
                    'venceEn' => null
                ]);
        }

        // Limpiar el carrito
        $this->pedido = [];
        $this->mostrarResumen = false;
}



    public function render()
    {
        $productos = $this->productos;

        if ($this->categoriaSeleccionada) {
            $productos = $productos->where(
                'idCategoria',
                $this->categoriaSeleccionada
            );
        }

        if ($this->buscar !== '') {
            $productos = $productos->filter(function ($producto) {
                return str_contains(
                    strtolower($producto->nombre),
                    strtolower($this->buscar)
                );
            });
        }

        return view('livewire.menu', [
            'productosFiltrados' => $productos,
        ]);
    }
}
