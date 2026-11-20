
<div wire:poll.10s="actualizarDatos" class="space-y-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-au-brown-darkest">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-au-text-muted">
                Resumen general de orden sistem
            </p>
        </div>

        <span class="text-sm capitalize text-au-text-muted">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- FILTROS DE FECHAS --}}
    <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

        <div class="mb-4 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-au-coral"></i>
            <h2 class="font-bold text-au-brown-darkest">
                Consultar historial
            </h2>
        </div>

        {{-- FILTROS RÁPIDOS --}}
        <div class="mb-5 flex flex-wrap gap-2">

            <button wire:click="seleccionarPeriodo('hoy')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Hoy
            </button>

            <button wire:click="seleccionarPeriodo('ayer')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Ayer
            </button>

            <button wire:click="seleccionarPeriodo('7dias')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Últimos 7 días
            </button>

            <button wire:click="seleccionarPeriodo('30dias')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Últimos 30 días
            </button>

            <button wire:click="seleccionarPeriodo('mes')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Este mes
            </button>

            <button wire:click="seleccionarPeriodo('mesAnterior')"
                class="rounded-lg bg-au-cream px-4 py-2 text-sm font-medium text-au-brown-darkest transition hover:bg-au-coral hover:text-white">
                Mes anterior
            </button>

        </div>

        {{-- SELECCIÓN PERSONALIZADA --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div>
                <label class="mb-1 block text-sm font-medium text-au-brown-dark">
                    Fecha inicial
                </label>

                <input type="date"
                    wire:model.live="fechaInicio"
                    class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm focus:border-au-coral focus:outline-none focus:ring-1 focus:ring-au-coral">

                @error('fechaInicio')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-au-brown-dark">
                    Fecha final
                </label>

                <input type="date"
                    wire:model.live="fechaFin"
                    class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm focus:border-au-coral focus:outline-none focus:ring-1 focus:ring-au-coral">

                @error('fechaFin')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end">
                <button wire:click="actualizarDatos"
                    wire:loading.attr="disabled"
                    class="w-full rounded-lg bg-au-coral px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90 disabled:opacity-50">

                    <span wire:loading.remove wire:target="actualizarDatos">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i>
                        Consultar período
                    </span>

                    <span wire:loading wire:target="actualizarDatos">
                        Consultando...
                    </span>
                </button>
            </div>

        </div>

        <p class="mt-3 text-xs text-au-text-muted">
            Mostrando información desde
            {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
            hasta
            {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}.
        </p>

    </div>


    {{-- INDICADORES PRINCIPALES --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- VENTAS --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Ventas realizadas
                </p>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                $ {{ number_format((float) $ventas, 0, ',', '.') }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Total de facturas pagadas
            </p>
        </div>


        {{-- PEDIDOS --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Pedidos registrados
                </p>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                {{ $pedidos }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Pedidos del período
            </p>
        </div>


        {{-- POR COBRAR --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Dinero por cobrar
                </p>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-money-bill-transfer text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                $ {{ number_format((float) $porCobrar, 0, ',', '.') }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Pedidos entregados sin pagar
            </p>
        </div>


        {{-- FACTURADOS --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Pedidos pagados
                </p>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                {{ $facturados }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Facturas pagadas
            </p>
        </div>

    </div>


    {{-- ESTADOS DE LOS PEDIDOS --}}
    <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

        <h2 class="mb-5 font-bold text-au-brown-darkest">
            Estado de los pedidos
        </h2>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">

            <div class="rounded-lg bg-au-cream p-4">
                <p class="text-sm text-au-text-muted">Pendientes</p>
                <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                    {{ $pendientes }}
                </p>
            </div>

            <div class="rounded-lg bg-au-cream p-4">
                <p class="text-sm text-au-text-muted">En preparación</p>
                <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                    {{ $preparacion }}
                </p>
            </div>

            <div class="rounded-lg bg-au-cream p-4">
                <p class="text-sm text-au-text-muted">Listos</p>
                <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                    {{ $listos }}
                </p>
            </div>

            <div class="rounded-lg bg-au-cream p-4">
                <p class="text-sm text-au-text-muted">Entregados</p>
                <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                    {{ $entregados }}
                </p>
            </div>

        </div>

    </div>


    {{-- VENTAS Y COMPARACIÓN --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

        {{-- VENTAS POR DÍA --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <div class="mb-5">
                <h2 class="font-bold text-au-brown-darkest">
                    Historial de ventas
                </h2>

                <p class="mt-1 text-xs text-au-text-muted">
                    Ventas agrupadas por día
                </p>
            </div>

            @php
                $maxVenta = collect($ventasPorDia)->max('total') ?: 1;
            @endphp

            @forelse($ventasPorDia as $venta)

                @php
                    $porcentaje = ((float) $venta->total / (float) $maxVenta) * 100;
                @endphp

                <div class="mb-4">
                    <div class="mb-1 flex justify-between gap-2 text-sm">
                        <span class="text-au-brown-dark">
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                        </span>

                        <span class="font-semibold text-au-brown-darkest">
                            ${{ number_format((float) $venta->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-au-cream">
                        <div class="h-full rounded-full bg-au-coral"
                            style="width: {{ $porcentaje }}%">
                        </div>
                    </div>
                </div>

            @empty

                <div class="py-8 text-center">
                    <i class="fa-solid fa-chart-column text-3xl text-au-text-muted"></i>

                    <p class="mt-3 text-sm text-au-text-muted">
                        No hay ventas registradas en este período.
                    </p>
                </div>

            @endforelse

        </div>


        {{-- COMPARACIÓN --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <h2 class="font-bold text-au-brown-darkest">
                Comparación de ventas
            </h2>

            <p class="mt-1 text-xs text-au-text-muted">
                Comparación con el período anterior
            </p>

            <div class="mt-6">
                <p class="text-sm text-au-text-muted">
                    Período seleccionado
                </p>

                <p class="mt-1 text-2xl font-bold text-au-brown-darkest">
                    $ {{ number_format((float) $ventas, 0, ',', '.') }}
                </p>
            </div>

            <div class="mt-5">
                <p class="text-sm text-au-text-muted">
                    Período anterior
                </p>

                <p class="mt-1 text-xl font-semibold text-au-brown-darkest">
                    $ {{ number_format((float) $ventasPeriodoAnterior, 0, ',', '.') }}
                </p>
            </div>

            <div class="mt-5 border-t border-au-cream-border pt-4">

                @if($variacionVentas !== null)

                    <p class="text-sm font-semibold {{ $variacionVentas >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fa-solid {{ $variacionVentas >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1"></i>

                        {{ number_format(abs($variacionVentas), 2, ',', '.') }}%

                        {{ $variacionVentas >= 0 ? 'de aumento' : 'de disminución' }}
                    </p>

                @else

                    <p class="text-sm text-au-text-muted">
                        No hay ventas anteriores suficientes para comparar.
                    </p>

                @endif

            </div>

        </div>

    </div>


    {{-- PRODUCTOS Y PAGOS --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

        {{-- PRODUCTOS MÁS VENDIDOS --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-au-brown-darkest">
                        Productos más vendidos
                    </h2>

                    <p class="mt-1 text-xs text-au-text-muted">
                        Los 5 productos destacados del período
                    </p>
                </div>

                <i class="fa-solid fa-crown text-xl text-au-coral"></i>
            </div>

            @forelse($productosMasVendidos as $indice => $producto)

                <div class="flex items-center justify-between gap-3 border-b border-au-cream-border py-3 last:border-0">

                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-au-cream font-bold text-au-brown-darkest">
                            {{ $indice + 1 }}
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-au-brown-darkest">
                                {{ $producto->nombre }}
                            </p>

                            <p class="text-xs text-au-text-muted">
                                {{ $producto->cantidadVendida }} unidades
                            </p>
                        </div>
                    </div>

                    <p class="text-sm font-bold text-au-brown-darkest">
                        ${{ number_format((float) $producto->totalVendido, 0, ',', '.') }}
                    </p>

                </div>

            @empty

                <p class="py-8 text-center text-sm text-au-text-muted">
                    No hay productos vendidos en este período.
                </p>

            @endforelse

        </div>


        {{-- MÉTODOS DE PAGO --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <div class="mb-5">
                <h2 class="font-bold text-au-brown-darkest">
                    Métodos de pago
                </h2>

                <p class="mt-1 text-xs text-au-text-muted">
                    Distribución del dinero recibido
                </p>
            </div>

            @php
                $efectivo = (float) ($metodosPago->efectivo ?? 0);
                $tarjeta = (float) ($metodosPago->tarjeta ?? 0);
                $transferencia = (float) ($metodosPago->transferencia ?? 0);
                $totalMetodos = $efectivo + $tarjeta + $transferencia;
            @endphp

            @foreach([
                ['nombre' => 'Efectivo', 'valor' => $efectivo, 'icono' => 'fa-money-bill-wave'],
                ['nombre' => 'Tarjeta', 'valor' => $tarjeta, 'icono' => 'fa-credit-card'],
                ['nombre' => 'Transferencia', 'valor' => $transferencia, 'icono' => 'fa-building-columns']
            ] as $metodo)

                @php
                    $porcentajePago = $totalMetodos > 0
                        ? ($metodo['valor'] / $totalMetodos) * 100
                        : 0;
                @endphp

                <div class="mb-5">

                    <div class="mb-2 flex items-center justify-between gap-2">

                        <div class="flex items-center gap-2 text-sm font-medium text-au-brown-darkest">
                            <i class="fa-solid {{ $metodo['icono'] }} text-au-coral"></i>
                            {{ $metodo['nombre'] }}
                        </div>

                        <span class="text-sm font-semibold text-au-brown-darkest">
                            ${{ number_format($metodo['valor'], 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-au-cream">
                        <div class="h-full rounded-full bg-au-coral"
                            style="width: {{ $porcentajePago }}%">
                        </div>
                    </div>

                    <p class="mt-1 text-right text-xs text-au-text-muted">
                        {{ number_format($porcentajePago, 1, ',', '.') }}%
                    </p>

                </div>

            @endforeach

        </div>

    </div>


    {{-- INFORMACIÓN ACTUAL DEL NEGOCIO --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-au-text-muted">
                        Mesas ocupadas actualmente
                    </p>

                    <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                        {{ $mesasOcupadas }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-chair text-xl"></i>
                </div>
            </div>

        </div>


        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-au-text-muted">
                        Productos agotados actualmente
                    </p>

                    <p class="mt-2 text-2xl font-bold text-au-brown-darkest">
                        {{ $productosAgotados }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
            </div>

        </div>

    </div>

</div>
