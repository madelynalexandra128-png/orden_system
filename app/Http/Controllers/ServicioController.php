<?php

namespace App\Http\Controllers;

use App\Services\ServicioService;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    private ServicioService $servicioService;

    public function __construct(ServicioService $servicioService)
    {
        $this->servicioService = $servicioService;
    }

    public function index()
    {
        $pedidosListos = $this->servicioService->listarPedidosListos();

        $pedidosEntregados = $this->servicioService->listarPedidosEntregados();

        return view('Servicio.Index', compact(
            'pedidosListos',
            'pedidosEntregados'
        ));
    }

    public function entregarProducto(int $idFactura, int $idDetalle)
    {
        $resultado = $this->servicioService->entregarProducto(
            $idFactura,
            $idDetalle
        );

        if (!$resultado) {
            return redirect()->route('servicio.index')
                ->with('error', 'No se pudo registrar la entrega del producto.');
        }

        return redirect()->route('servicio.index')
            ->with('success', 'Producto marcado como entregado.');
    }
}
