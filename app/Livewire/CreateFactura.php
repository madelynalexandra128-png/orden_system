<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CreateFactura extends Component
{
    
    public  $clientes = [];

    public  $mesas = [];

    public $totalFactura = 0;

    public $totalPuntos = 0;

    public $metodoPago = 'Efectivo';

    public $montoRecibido = 0;
    public $montoTarjeta = 0;
    public $montoTransferencia = 0;

    // Método complementario para el pago mixto
    public $metodoMixto = 'Tarjeta';


    // Recibe los clientes y las mesas desde el controlador
    public function mount( $clientes,$mesas)
    {
        $this->clientes = $clientes;
        $this->mesas = $mesas;

        // Recuperar los datos anteriores si hubo errores al guardar
    $this->metodoPago = old('metodoPago', 'Efectivo');
    $this->metodoMixto = old('metodoMixto', 'Tarjeta');

    $this->montoRecibido = old('montoRecibido', 0);
    $this->montoTarjeta = old('montoTarjeta', 0);
    $this->montoTransferencia = old('montoTransferencia', 0);
    }


    // Escucha el evento que envía FacturaBuscar con el total
    #[On('total-actualizado')]
    public function actualizarTotal(float $total)
    {
        $this->totalFactura = $total;

        if ($this->metodoPago === 'Mixto') {
            $this->actualizarPagoMixto('efectivo');
        }
    }


    // Escucha el evento que envía FacturaBuscar con los puntos
    #[On('puntos-actualizados')]
    public function actualizarPuntos(int $puntos)
    {
        $this->totalPuntos = $puntos;
    }

    // Detecta los cambios en los campos de pago
    public function updated($propiedad)
    {
        if ($this->metodoPago !== 'Mixto') {
            return;
        }

        if ($propiedad === 'montoRecibido') {
            $this->actualizarPagoMixto('efectivo');
        }

        if (
            $propiedad === 'montoTarjeta' ||
            $propiedad === 'montoTransferencia'
        ) {
            $this->actualizarPagoMixto('segundo');
        }

        if ($propiedad === 'metodoMixto') {
            $this->actualizarPagoMixto('efectivo');
        }
    }

    // Calcula automáticamente el valor que falta
    public function actualizarPagoMixto($campo)
    {

        $total = round((float) $this->totalFactura);

        if ($campo === 'efectivo') {

            $efectivo = (float) $this->montoRecibido;

            $restante = max(0, $total - $efectivo);

            if ($this->metodoMixto === 'Tarjeta') {
                $this->montoTarjeta = $restante;
            } else {
                $this->montoTransferencia = $restante;
            }

        } else {

            if ($this->metodoMixto === 'Tarjeta') {
                $segundoPago = (float) $this->montoTarjeta;
            } else {
                $segundoPago = (float) $this->montoTransferencia;
            }

            $this->montoRecibido = max(0, $total - $segundoPago);
        }
    }

    // Calcula el cambio o vuelto
    public function calcularCambio()
    {
        $totalPagado = (float) $this->montoRecibido;

        if ($this->metodoPago === 'Mixto') {

            if ($this->metodoMixto === 'Tarjeta') {
                $totalPagado += (float) $this->montoTarjeta;
            } else {
                $totalPagado += (float) $this->montoTransferencia;
            }

        }

        return max(0, $totalPagado - (float) $this->totalFactura);
    }

    public function render()
    {
        return view('livewire.create-factura');
    }
}