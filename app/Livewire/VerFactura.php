<?php

namespace App\Livewire;

use App\Models\factura;
use Livewire\Component;

class VerFactura extends Component
{
    public int $idFactura;

    public bool $mostrarModal = false;

    public function abrirModal()
    {
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function render()
    {
        $factura = factura::with([
            'cliente',
            'detalleFactura.producto'
        ])->findOrFail($this->idFactura);

        return view('livewire.ver-factura', compact('factura'));
    }
    }
