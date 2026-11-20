<?php

namespace App\Http\Controllers;

use App\Services\BarraService;
use Illuminate\Http\Request;

class BarraController extends Controller
{
    private BarraService $barraService;

    public function __construct(BarraService $barraService)
    {
        $this->barraService = $barraService;
    }

    public function index()
    {
        $pedidos = $this->barraService->listarPedidos();

        return view('Barra.Index', compact('pedidos'));
    }

    public function cambiarEstado(int $idFactura)
    {
        $resultado = $this->barraService->cambiarAEnPreparacion($idFactura);

        if (!$resultado) {
            return redirect()->route('barra.index')
                ->with('error', 'Este pedido ya no está pendiente.');
        }

        return redirect()->route('barra.index')
            ->with('success', 'El pedido pasó a preparación correctamente.');
    }

    public function cambiarAListo(int $idFactura)
    {
        $resultado = $this->barraService->cambiarAListo($idFactura);

        if (!$resultado) {
            return redirect()->route('barra.index')
                ->with('error', 'Este pedido ya no está en preparación.');
        }

        return redirect()->route('barra.index')
            ->with('success', 'El pedido está listo para entregar.');
    }

}
