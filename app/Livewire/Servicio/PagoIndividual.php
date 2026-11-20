<?php

namespace App\Livewire\Servicio;

use App\Services\FacturaService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PagoIndividual extends Component
{
    public $idFactura;

    public $totalPago = 0;

    // Método de pago
    public $metodoPago = 'Efectivo';

    // Efectivo
    public $montoRecibido = 0;

    // Pago mixto
    public $metodoMixto = 'Tarjeta';
    public $montoTarjeta = 0;
    public $montoTransferencia = 0;

    public function mount(int $idFactura)
    {
        $this->idFactura = $idFactura;

        $facturaService = app(FacturaService::class);

        $factura = $facturaService->buscasrIdFactura($idFactura);

        if (!$factura || $factura->estado !== 'Entregado') {
            throw ValidationException::withMessages([
                'pago' => 'Esta orden no está disponible para pagar.'
            ]);
        }

        $this->totalPago = (float) $factura->total;
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
                $this->totalPago - (float) $this->montoTarjeta
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
                $this->totalPago - (float) $this->montoTransferencia
            );
        }
    }

    // Calcular el valor restante del pago mixto
    public function actualizarPagoMixto()
    {
        $restante = max(
            0,
            $this->totalPago - (float) $this->montoRecibido
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
            (float) $this->montoRecibido - $this->totalPago
        );
    }

    // Registrar pago individual
    public function registrarPago()
    {
        $datos = [
            'metodoPago' => $this->metodoPago,
            'montoRecibido' => $this->montoRecibido,
            'metodoMixto' => $this->metodoMixto,
            'montoTarjeta' => $this->montoTarjeta,
            'montoTransferencia' => $this->montoTransferencia,
        ];

        $facturaService = app(FacturaService::class);

        $facturaService->registrarPago(
            (int) $this->idFactura,
            $datos
        );

        $this->dispatch('pago-individual-registrado');
    }

    public function cerrar()
    {
        $this->dispatch('cerrar-pago-individual');
    }

    public function render()
    {
        return view('livewire.servicio.pago-individual');
    }
}
