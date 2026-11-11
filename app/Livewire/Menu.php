<?php

namespace App\Livewire;

use App\Services\MenuQrService;
use Livewire\Component;

class Menu extends Component
{
    public $mesa;
    public $productos;
    public $categorias;

    public $categoriaSeleccionada = null;
    public $buscar = '';

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
