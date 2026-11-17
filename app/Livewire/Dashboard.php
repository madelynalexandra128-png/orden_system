<?php

namespace App\Livewire;

use App\Models\factura;
use App\Models\mesa;
use App\Models\producto;
use Livewire\Component;

class Dashboard extends Component
{
    public $ventasHoy = 0;
    public $pedidosHoy = 0;
    public $mesasOcupadas = 0;
    public $productosAgotados = 0;

    public function actualizarDatos()
    {
        $this->ventasHoy = factura::where('estado', 'Facturado')
            ->whereDate('created_at', today())
            ->sum('total');

        $this->pedidosHoy = factura::whereDate('created_at', today())
            ->count();

        $this->mesasOcupadas = mesa::where('estado', 'Ocupada')
            ->count();

        $this->productosAgotados = producto::where('stock', '<=', 0)
            ->count();
    }

    public function mount()
    {
        $this->actualizarDatos();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}