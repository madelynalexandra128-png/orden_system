<?php

namespace App\Services;

use App\Repositories\MenuQrRepository;

class MenuQrService{

    private MenuQrRepository $menuQrRepository;
    private ProductoService $productoService;


    public function __construct(MenuQrRepository $menuQrRepository, ProductoService $productoService)
    {
        $this->menuQrRepository=$menuQrRepository;

        $this->productoService= $productoService;

        
        
    }

    public function mostrarMenu(string $codigoQr)
    {
        $mesa = $this->menuQrRepository->buscarMesaPorCodigo($codigoQr);

        $productos = $this->productoService->listarProductosDisponibles();

        $categorias = $this->menuQrRepository->listarCategoriasDisponibles();

        return [
            'mesa' => $mesa,
            'productos' => $productos,
            'categorias' => $categorias,
        ];
    }

}