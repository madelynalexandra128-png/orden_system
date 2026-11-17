<?php

namespace App\Repositories;

use App\Models\factura;
use App\Models\mesa;
use App\Models\producto;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    // Resumen de ventas y pedidos del período
    public function obtenerResumen(string $inicio, string $fin)
    {
        return [
            'ventas' => factura::where('estado', 'Facturado')
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('total'),

            'pedidos' => factura::whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'pendientes' => factura::where('estado', 'Pendiente')
                ->whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'preparacion' => factura::where('estado', 'En preparación')
                ->whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'listos' => factura::where('estado', 'Listo')
                ->whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'entregados' => factura::where('estado', 'Entregado')
                ->whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'facturados' => factura::where('estado', 'Facturado')
                ->whereBetween('fecha', [$inicio, $fin])
                ->count(),

            'porCobrar' => factura::where('estado', 'Entregado')
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('total'),
        ];
    }

    // Ventas agrupadas por día
    public function obtenerVentasPorDia(string $inicio, string $fin)
    {
        return factura::selectRaw('fecha, SUM(total) as total')
            ->where('estado', 'Facturado')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    }

    // Productos más vendidos
    public function obtenerProductosMasVendidos(string $inicio, string $fin)
    {
        return DB::table('detalleFactura as detalle')
            ->join('factura as f', 'f.id', '=', 'detalle.idFactura')
            ->join('producto as p', 'p.id', '=', 'detalle.idProducto')
            ->where('f.estado', 'Facturado')
            ->whereBetween('f.fecha', [$inicio, $fin])
            ->select(
                'p.id',
                'p.nombre',
                DB::raw('SUM(detalle.cantidad) as cantidadVendida'),
                DB::raw('SUM(detalle.total) as totalVendido')
            )
            ->groupBy('p.id', 'p.nombre')
            ->orderByDesc('cantidadVendida')
            ->limit(5)
            ->get();
    }

    // Métodos de pago
    public function obtenerMetodosPago(string $inicio, string $fin)
    {
        return factura::where('estado', 'Facturado')
            ->whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('
                SUM(montoEfectivo) as efectivo,
                SUM(montoTarjeta) as tarjeta,
                SUM(montoTransferencia) as transferencia
            ')
            ->first();
    }

    // Mesas ocupadas actualmente
    public function obtenerMesasOcupadas()
    {
        return mesa::where('estado', 'Ocupada')->count();
    }

    // Productos agotados actualmente
    public function obtenerProductosAgotados()
    {
        return producto::where('stock', '<=', 0)->count();
    }
}
