<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CreateFactura extends Component
{
    
    public $clientes = [];

    public $mesas = [];

    public $totalFactura = 0;

    public $totalPuntos = 0;

    public $metodoPgo = 'Efectivo';

    public $montoRecibido = 0;
    public $montoTarjeta = 0;
    public $montoTransferencia = 0;

    // Método complementario para el pago mixto
    public $metodoMixto = 'Tarjeta';


    // Recibe los clientes y las mesas desde el controlador
    public function mount($clientes, $mesas)
    {
        $this->clientes = $clientes;
        $this->mesas = $mesas;
    }


    // Escucha el evento que envía FacturaBuscar con el total
    #[On('total-actualizado')]
    public function actualizarTotal($total)
    {
        $this->totalFactura = $total;
    }


    // Escucha el evento que envía FacturaBuscar con los puntos
    #[On('puntos-actualizados')]
    public function actualizarPuntos($puntos)
    {
        $this->totalPuntos = $puntos;
    }

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