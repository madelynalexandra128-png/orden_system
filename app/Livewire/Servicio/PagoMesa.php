<?php

namespace App\Livewire\Servicio;

use App\Services\FacturaService;
use App\Services\ServicioService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PagoMesa extends Component
{
    public $idMesa;

    public $nombreMesa = '';

    public $pedidosMesa = [];

    public $totalMesa = 0;

    // Método de pago
    public $metodoPago = 'Efectivo';

    // Efectivo
    public $montoRecibido = 0;

    // Pago mixto
    public $metodoMixto = 'Tarjeta';
    public $montoTarjeta = 0;
    public $montoTransferencia = 0;

    public function mount(int $idMesa)
    {
        $this->idMesa = $idMesa;

        $this->cargarPedidosMesa();
    }

    // Consultar órdenes entregadas de la mesa
    public function cargarPedidosMesa()
    {
        $servicioService = app(ServicioService::class);

        $pedidos = $servicioService->listarPedidosEntregadosPorMesa(
            $this->idMesa
        );

        if ($pedidos->isEmpty()) {
            throw ValidationException::withMessages([
                'pago' => 'La mesa no tiene órdenes entregadas pendientes de pago.'
            ]);
        }

        $this->pedidosMesa = $pedidos->map(function ($pedido) {
            return [
                'id' => $pedido->id,
                'total' => (float) $pedido->total,
            ];
        })->toArray();

        $this->nombreMesa = $pedidos->first()->mesa?->nombre ?? 'Mesa';

        $this->totalMesa = (float) $pedidos->sum('total');
    }

    // Reiniciar valores al cambiar método
    public function updatedMetodoPago()
    {
        $this->montoRecibido = 0;
        $this->montoTarjeta = 0;
        $this->montoTransferencia = 0;

        if ($this->metodoPago === 'Mixto') {
            $this->actualizarPagoMixto();
        }
    }

    public function updatedMetodoMixto()
    {
        $this->actualizarPagoMixto();
    }

    public function updatedMontoRecibido()
    {
        if ($this->metodoPago === 'Mixto') {
            $this->actualizarPagoMixto();
        }
    }

    public function updatedMontoTarjeta()
    {
        if (
            $this->metodoPago === 'Mixto' &&
            $this->metodoMixto === 'Tarjeta'
        ) {
            $this->montoRecibido = max(
                0,
                $this->totalMesa - (float) $this->montoTarjeta
            );
        }
    }

    public function updatedMontoTransferencia()
    {
        if (
            $this->metodoPago === 'Mixto' &&
            $this->metodoMixto === 'Transferencia'
        ) {
            $this->montoRecibido = max(
                0,
                $this->totalMesa - (float) $this->montoTransferencia
            );
        }
    }

    // Calcular valor restante del pago mixto
    public function actualizarPagoMixto()
    {
        $restante = max(
            0,
            $this->totalMesa - (float) $this->montoRecibido
        );

        if ($this->metodoMixto === 'Tarjeta') {
            $this->montoTarjeta = $restante;
            $this->montoTransferencia = 0;
        } else {
            $this->montoTransferencia = $restante;
            $this->montoTarjeta = 0;
        }
    }

    // Calcular cambio
    public function calcularCambio()
    {
        if ($this->metodoPago !== 'Efectivo') {
            return 0;
        }

        return max(
            0,
            (float) $this->montoRecibido - $this->totalMesa
        );
    }

    // Registrar pago de todas las órdenes de la mesa
    public function registrarPagoMesa()
    {
        $datos = [
            'metodoPago' => $this->metodoPago,
            'montoRecibido' => $this->montoRecibido,
            'metodoMixto' => $this->metodoMixto,
            'montoTarjeta' => $this->montoTarjeta,
            'montoTransferencia' => $this->montoTransferencia,
        ];

        $facturaService = app(FacturaService::class);

        $facturaService->registrarPagoMesa(
            (int) $this->idMesa,
            $datos
        );

        $this->dispatch('pago-mesa-registrado');
    }

    public function cerrar()
    {
        $this->dispatch('cerrar-pago-mesa');
    }

    public function render()
    {
        return view('livewire.servicio.pago-mesa');
    }
}
