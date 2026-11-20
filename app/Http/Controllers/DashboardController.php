<?php

namespace App\Http\Controllers;

use App\Models\factura;
use App\Models\mesa;
use App\Models\producto;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas realizadas hoy
        $ventasHoy = factura::where('estado', 'Facturado')
            ->whereDate('created_at', today())
            ->sum('total');

        // Pedidos registrados hoy
        $pedidosHoy = factura::whereDate('created_at', today())
            ->count();

        // Mesas ocupadas
        $mesasOcupadas = mesa::where('estado', 'Ocupada')
            ->count();

        // Productos agotados
        $productosAgotados = producto::where('stock', '<=', 0)
            ->count();

        return view('home', compact(
            'ventasHoy',
            'pedidosHoy',
            'mesasOcupadas',
            'productosAgotados'
        ));
    }
}