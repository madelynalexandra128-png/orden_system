<?php

namespace App\Services;

use App\Repositories\DashboardRepository;
use Carbon\Carbon;

class DashboardService
{
    private DashboardRepository $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    // Obtener toda la información del dashboard
    public function obtenerDatos(string $inicio, string $fin)
    {
        $resumen = $this->dashboardRepository->obtenerResumen(
            $inicio,
            $fin
        );

        $ventasPorDia = $this->dashboardRepository->obtenerVentasPorDia(
            $inicio,
            $fin
        );

        $productosMasVendidos = $this->dashboardRepository->obtenerProductosMasVendidos(
            $inicio,
            $fin
        );

        $metodosPago = $this->dashboardRepository->obtenerMetodosPago(
            $inicio,
            $fin
        );

        $mesasOcupadas = $this->dashboardRepository->obtenerMesasOcupadas();

        $productosAgotados = $this->dashboardRepository->obtenerProductosAgotados();

        return [
            'resumen' => $resumen,
            'ventasPorDia' => $ventasPorDia,
            'productosMasVendidos' => $productosMasVendidos,
            'metodosPago' => $metodosPago,
            'mesasOcupadas' => $mesasOcupadas,
            'productosAgotados' => $productosAgotados,
        ];
    }

    // Obtener el período anterior para comparar ventas
    public function obtenerPeriodoAnterior(string $inicio, string $fin)
    {
        $fechaInicio = Carbon::parse($inicio);
        $fechaFin = Carbon::parse($fin);

        $dias = $fechaInicio->diffInDays($fechaFin) + 1;

        $finAnterior = $fechaInicio->copy()->subDay();
        $inicioAnterior = $finAnterior->copy()->subDays($dias - 1);

        return [
            'inicio' => $inicioAnterior->toDateString(),
            'fin' => $finAnterior->toDateString(),
        ];
    }
}
