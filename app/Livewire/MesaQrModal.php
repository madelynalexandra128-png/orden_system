<?php

namespace App\Livewire;

use App\Models\mesa;
use Livewire\Component;
use Livewire\Attributes\On;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MesaQrModal extends Component
{
    public bool $abierto = false;

    public ?mesa $mesaSeleccionada = null;

    public string $qrSvg = '';

    #[On('abrir-qr')]
    public function abrirQr(int $mesaId): void
    {
        $this->mesaSeleccionada = mesa::findOrFail($mesaId);

        $urlMenu = url('/menu/' . $this->mesaSeleccionada->codigoQr);

        $this->qrSvg = QrCode::format('svg')
            ->size(320)
            ->margin(1)
            ->generate($urlMenu);

        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->mesaSeleccionada = null;
        $this->qrSvg = '';
    }

    public function render()
    {
        return view('livewire.mesa-qr-modal');
    }
}
