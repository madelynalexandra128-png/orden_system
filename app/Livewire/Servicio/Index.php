<?php

namespace App\Livewire\Servicio;

use App\Services\ServicioService;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    // Control de los modales
    public $mostrarPagoIndividual = false;
    public $mostrarPagoMesa = false;

    // Identificadores
    public $idFacturaPago = null;
    public $idMesaPago = null;

    // Abrir pago individual
    public function abrirModalPago(int $idFactura)
    {
        $this->idFacturaPago = $idFactura;

        $this->mostrarPagoIndividual = true;
        $this->mostrarPagoMesa = false;
    }

    // Abrir pago de mesa completa
    public function abrirModalPagoMesa(int $idMesa)
    {
        $servicioService = app(ServicioService::class);

        $pedidos = $servicioService->listarPedidosEntregadosPorMesa($idMesa);

        if ($pedidos->isEmpty()) {
            session()->flash(
                'error',
                'Esta mesa no tiene órdenes entregadas pendientes de pago.'
            );

            return;
        }

        $this->idMesaPago = $idMesa;

        $this->mostrarPagoMesa = true;
        $this->mostrarPagoIndividual = false;
    }

    // Cerrar pago individual después de registrar
    #[On('pago-individual-registrado')]
    public function finalizarPagoIndividual()
    {
        $this->mostrarPagoIndividual = false;
        $this->idFacturaPago = null;

        session()->flash('success', 'Pago registrado correctamente.');
    }

    // Cerrar pago de mesa después de registrar
    #[On('pago-mesa-registrado')]
    public function finalizarPagoMesa()
    {
        $this->mostrarPagoMesa = false;
        $this->idMesaPago = null;

        session()->flash('success', 'Pago de mesa registrado correctamente.');
    }

    #[On('cerrar-pago-individual')]
    public function cerrarModalIndividual()
    {
        $this->mostrarPagoIndividual = false;
        $this->idFacturaPago = null;
    }

    #[On('cerrar-pago-mesa')]
    public function cerrarModalMesa()
    {
        $this->mostrarPagoMesa = false;
        $this->idMesaPago = null;
    }

    // Registrar entrega de productos
    public function entregarProducto(int $idFactura, int $idDetalle)
    {
        $servicioService = app(ServicioService::class);

        $resultado = $servicioService->entregarProducto(
            $idFactura,
            $idDetalle
        );

        if (!$resultado) {
            session()->flash('error', 'No se pudo registrar la entrega.');
            return;
        }

        session()->flash('success', 'Producto marcado como entregado.');
    }

    public function render()
    {
        $servicioService = app(ServicioService::class);

        return view('livewire.servicio.index', [
            'pedidosListos' => $servicioService->listarPedidosListos(),
            'pedidosEntregados' => $servicioService->listarPedidosEntregados(),
        ]);
    }
}
