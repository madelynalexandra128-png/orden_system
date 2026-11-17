
<div wire:poll.10s="actualizarDatos" class="space-y-6">

    {{-- Encabezado --}}
    <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-au-brown-darkest">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-au-text-muted">
                Resumen general del café bar
            </p>
        </div>

        <span class="text-sm text-au-text-muted">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- Indicadores principales --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Ventas --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Ventas del día
                </p>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                $ {{ number_format($ventasHoy, 0, ',', '.') }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Total facturado hoy
            </p>
        </div>

        {{-- Pedidos --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Pedidos de hoy
                </p>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                {{ $pedidosHoy }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Pedidos registrados hoy
            </p>
        </div>

        {{-- Mesas --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Mesas ocupadas
                </p>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-chair text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                {{ $mesasOcupadas }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Mesas actualmente ocupadas
            </p>
        </div>

        {{-- Productos agotados --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-au-text-muted">
                    Productos agotados
                </p>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-au-cream text-au-coral">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
            </div>

            <p class="mt-4 text-2xl font-bold text-au-brown-darkest">
                {{ $productosAgotados }}
            </p>

            <p class="mt-1 text-xs text-au-text-muted">
                Productos sin existencias
            </p>
        </div>

    </div>

    {{-- Espacio para las siguientes secciones --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <h2 class="font-bold text-au-brown-darkest">
                Resumen de ventas
            </h2>
            <p class="mt-2 text-sm text-au-text-muted">
                Aquí mostraremos la gráfica de ventas.
            </p>
        </div>

        <div class="rounded-xl border border-au-cream-border bg-white p-5 shadow-sm">
            <h2 class="font-bold text-au-brown-darkest">
                Productos más vendidos
            </h2>
            <p class="mt-2 text-sm text-au-text-muted">
                Aquí mostraremos los productos con mayores ventas.
            </p>
        </div>

    </div>

</div>
