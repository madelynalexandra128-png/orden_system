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

    public function cambiarEstado(int $idFactura)
    {
        $resultado = $this->servicioService->cambiarAEntregado($idFactura);

        if (!$resultado) {
            return redirect()->route('servicio.index')
                ->with('error', 'Este pedido ya no está listo para entregar.');
        }

        return redirect()->route('servicio.index')
            ->with('success', 'El pedido fue entregado correctamente.');
    }
}
