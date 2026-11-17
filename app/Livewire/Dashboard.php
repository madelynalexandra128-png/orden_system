<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    protected DashboardService $dashboardService;

    // Filtros de fechas
    public $fechaInicio;
    public $fechaFin;

    // Indicadores principales
    public $ventas = 0;
    public $pedidos = 0;
    public $pendientes = 0;
    public $preparacion = 0;
    public $listos = 0;
    public $entregados = 0;
    public $facturados = 0;
    public $porCobrar = 0;

    // Información actual
    public $mesasOcupadas = 0;
    public $productosAgotados = 0;

    // Estadísticas adicionales
    public $ventasPorDia = [];
    public $productosMasVendidos = [];
    public $metodosPago = [];

    // Comparación de períodos
    public $ventasPeriodoAnterior = 0;
    public $variacionVentas = null;

    public function boot(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function mount()
    {
        $this->fechaInicio = today()->toDateString();
        $this->fechaFin = today()->toDateString();

        $this->actualizarDatos();
    }

    // Consultar información del dashboard
    public function actualizarDatos()
    {
        if (!$this->fechaInicio || !$this->fechaFin) {
            return;
        }

        $inicio = Carbon::parse($this->fechaInicio);
        $fin = Carbon::parse($this->fechaFin);

        if ($inicio->gt($fin)) {
            $this->addError(
                'fechaInicio',
                'La fecha inicial no puede ser posterior a la fecha final.'
            );

            return;
        }

        $this->resetValidation();

        $datos = $this->dashboardService->obtenerDatos(
            $this->fechaInicio,
            $this->fechaFin
        );

        $resumen = $datos['resumen'];

        $this->ventas = $resumen['ventas'];
        $this->pedidos = $resumen['pedidos'];
        $this->pendientes = $resumen['pendientes'];
        $this->preparacion = $resumen['preparacion'];
        $this->listos = $resumen['listos'];
        $this->entregados = $resumen['entregados'];
        $this->facturados = $resumen['facturados'];
        $this->porCobrar = $resumen['porCobrar'];

        $this->mesasOcupadas = $datos['mesasOcupadas'];
        $this->productosAgotados = $datos['productosAgotados'];

        $this->ventasPorDia = $datos['ventasPorDia'];
        $this->productosMasVendidos = $datos['productosMasVendidos'];
        $this->metodosPago = $datos['metodosPago'];

        // Comparar con el período anterior
        $periodoAnterior = $this->dashboardService
            ->obtenerPeriodoAnterior(
                $this->fechaInicio,
                $this->fechaFin
            );

        $datosAnteriores = $this->dashboardService->obtenerDatos(
            $periodoAnterior['inicio'],
            $periodoAnterior['fin']
        );

        $this->ventasPeriodoAnterior =
            $datosAnteriores['resumen']['ventas'];

        if ($this->ventasPeriodoAnterior > 0) {
            $this->variacionVentas = (
                ($this->ventas - $this->ventasPeriodoAnterior)
                / $this->ventasPeriodoAnterior
            ) * 100;
        } else {
            $this->variacionVentas = null;
        }
    }

    // Filtros rápidos
    public function seleccionarPeriodo(string $periodo)
    {
        $hoy = Carbon::today();

        switch ($periodo) {
            case 'hoy':
                $inicio = $hoy->copy();
                $fin = $hoy->copy();
                break;

            case 'ayer':
                $inicio = $hoy->copy()->subDay();
                $fin = $inicio->copy();
                break;

            case '7dias':
                $inicio = $hoy->copy()->subDays(6);
                $fin = $hoy->copy();
                break;

            case '30dias':
                $inicio = $hoy->copy()->subDays(29);
                $fin = $hoy->copy();
                break;

            case 'mes':
                $inicio = $hoy->copy()->startOfMonth();
                $fin = $hoy->copy()->endOfMonth();

                if ($fin->gt($hoy)) {
                    $fin = $hoy->copy();
                }
                break;

            case 'mesAnterior':
                $inicio = $hoy->copy()->subMonthNoOverflow()
                    ->startOfMonth();

                $fin = $hoy->copy()->subMonthNoOverflow()
                    ->endOfMonth();
                break;

            default:
                return;
        }

        $this->fechaInicio = $inicio->toDateString();
        $this->fechaFin = $fin->toDateString();

        $this->actualizarDatos();
    }

    // Actualizar al cambiar la fecha inicial
    public function updatedFechaInicio()
    {
        $this->actualizarDatos();
    }

    // Actualizar al cambiar la fecha final
    public function updatedFechaFin()
    {
        $this->actualizarDatos();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
