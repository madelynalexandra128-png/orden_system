
<div class="min-h-screen bg-au-cream p-4 md:p-6">

    {{-- Encabezado --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-au-brown-dark">
            Control de servicio
        </h1>

        <p class="text-sm text-au-text-muted">
            Gestión de pedidos por entregar y entregados
        </p>
    </div>

    {{-- Mensajes --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-2">

        {{-- POR ENTREGAR --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-4 shadow-sm">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-au-brown-dark">
                    Por entregar
                </h2>

                <span class="rounded-full bg-au-cream-card px-3 py-1 text-xs font-semibold text-au-brown-dark">
                    {{ $pedidosListos->count() }}
                </span>
            </div>

            <div class="space-y-4">

                @forelse ($pedidosListos as $pedido)

                    <div wire:key="pedido-listo-{{ $pedido->id }}"
                         class="rounded-xl border border-au-cream-border p-4">

                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="font-bold text-au-brown-dark">
                                Orden #{{ $pedido->id }}
                            </h3>

                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Listo
                            </span>
                        </div>

                        <p class="mb-4 text-sm text-au-text-muted">
                            {{ $pedido->mesa?->nombre ?? 'Sin mesa' }}
                        </p>

                        {{-- Productos --}}
                        <div class="space-y-3">

                            @foreach ($pedido->detalleFactura as $detalle)

                                <button
                                    wire:click="entregarProducto({{ $pedido->id }}, {{ $detalle->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="entregarProducto({{ $pedido->id }}, {{ $detalle->id }})"
                                    @disabled($detalle->cantidadEntregada >= $detalle->cantidad)
                                    class="flex w-full items-center justify-between rounded-xl border p-3 text-left transition
                                    {{ $detalle->cantidadEntregada >= $detalle->cantidad
                                        ? 'cursor-not-allowed border-green-200 bg-green-50'
                                        : 'border-au-cream-border bg-au-cream hover:border-au-coral' }}">

                                    <div>
                                        <p class="font-semibold text-au-brown-dark">
                                            {{ $detalle->producto?->nombre ?? 'Producto no disponible' }}
                                        </p>

                                        <p class="mt-1 text-xs text-au-text-muted">
                                            Entregados:
                                            {{ $detalle->cantidadEntregada }}
                                            de
                                            {{ $detalle->cantidad }}
                                        </p>
                                    </div>

                                    <div class="text-right">

                                        @if ($detalle->cantidadEntregada >= $detalle->cantidad)

                                            <span class="text-sm font-semibold text-green-700">
                                                <i class="fas fa-check-circle"></i>
                                                Entregado
                                            </span>

                                        @else

                                            <span class="text-sm font-semibold text-au-brown-dark">
                                                <i class="far fa-square"></i>
                                                Marcar entrega
                                            </span>

                                        @endif

                                    </div>

                                </button>

                            @endforeach

                        </div>

                        {{-- Progreso --}}
                        @php
                            $totalUnidades = $pedido->detalleFactura->sum('cantidad');

                            $unidadesEntregadas = $pedido->detalleFactura->sum('cantidadEntregada');

                            $progreso = $totalUnidades > 0
                                ? ($unidadesEntregadas / $totalUnidades) * 100
                                : 0;
                        @endphp

                        <div class="mt-4 border-t border-au-cream-border pt-3">

                            <div class="mb-2 flex justify-between text-xs text-au-text-muted">
                                <span>Progreso de entrega</span>

                                <span class="font-semibold">
                                    {{ $unidadesEntregadas }} / {{ $totalUnidades }}
                                </span>
                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-au-cream-card">
                                <div
                                    class="h-full rounded-full bg-green-600 transition-all"
                                    style="width: {{ $progreso }}%">
                                </div>
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-lg bg-au-cream p-6 text-center">
                        <p class="font-medium text-au-brown-dark">
                            No hay pedidos por entregar.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>



        {{-- ENTREGADOS --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-4 shadow-sm">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-au-brown-dark">
                    Entregados
                </h2>

                <span class="rounded-full bg-au-cream-card px-3 py-1 text-xs font-semibold text-au-brown-dark">
                    {{ $pedidosEntregados->count() }}
                </span>
            </div>

            @php
                $pedidosAgrupados = $pedidosEntregados->groupBy('idMesa');
            @endphp

            <div class="space-y-3">

                @forelse ($pedidosAgrupados as $idMesa => $pedidosMesa)

                    @php
                        $totalMesa = $pedidosMesa->sum('total');
                        $nombreMesa = $pedidosMesa->first()->mesa?->nombre ?? 'Sin mesa';
                    @endphp

                    <div
                        wire:key="mesa-entregada-{{ $idMesa }}"
                        class="overflow-hidden rounded-xl border border-au-cream-border">

                        {{-- RESUMEN DE MESA --}}
                        <div class="bg-au-cream p-4">

                            <div class="flex items-center justify-between gap-3">

                                <div>
                                    <h3 class="font-bold text-au-brown-dark">
                                        {{ $nombreMesa }}
                                    </h3>

                                    <p class="mt-1 text-xs text-au-text-muted">
                                        {{ $pedidosMesa->count() }}
                                        {{ $pedidosMesa->count() === 1 ? 'orden entregada' : 'órdenes entregadas' }}
                                    </p>
                                </div>

                                <p class="text-lg font-bold text-au-brown-dark">
                                    ${{ number_format((float) $totalMesa, 0, ',', '.') }}
                                </p>

                            </div>

                            {{-- PAGAR MESA --}}
                            <button
                                type="button"
                                wire:click="abrirModalPagoMesa({{ $idMesa }})"
                                wire:loading.attr="disabled"
                                class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-au-coral px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90">

                                <i class="fas fa-cash-register"></i>
                                Pagar mesa completa

                            </button>

                        </div>

                        {{-- ÓRDENES INDIVIDUALES DESPLEGABLES --}}
                        <details class="group">

                            <summary class="flex cursor-pointer list-none items-center justify-between px-4 py-3 text-sm font-semibold text-au-brown-dark hover:bg-au-cream">

                                <span>
                                    <i class="fas fa-receipt mr-2"></i>
                                    Ver órdenes individuales
                                </span>

                                <i class="fas fa-chevron-down text-xs transition-transform group-open:rotate-180"></i>

                            </summary>

                            <div class="space-y-3 border-t border-au-cream-border bg-white p-3">

                                @foreach ($pedidosMesa as $pedido)

                                    <div
                                        wire:key="pedido-entregado-{{ $pedido->id }}"
                                        class="rounded-lg border border-au-cream-border p-3">

                                        <div class="mb-3 flex items-center justify-between">

                                            <span class="text-sm text-au-text-muted">
                                                Orden #{{ $pedido->id }}
                                            </span>

                                            <span class="font-bold text-au-brown-dark">
                                                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
                                            </span>

                                        </div>

                                        <button
                                            type="button"
                                            wire:click="abrirModalPago({{ $pedido->id }})"
                                            wire:loading.attr="disabled"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-au-brown-dark px-3 py-2 text-sm font-semibold text-white transition hover:bg-au-brown-darkest">

                                            <i class="fas fa-money-bill-wave"></i>
                                            Pagar esta orden

                                        </button>

                                    </div>

                                @endforeach

                            </div>

                        </details>

                    </div>

                @empty

                    <div class="rounded-lg bg-au-cream p-6 text-center">
                        <p class="font-medium text-au-brown-dark">
                            No hay pedidos entregados.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>


    </div>

    {{-- MODAL DE PAGO INDIVIDUAL --}}
    @if ($mostrarPagoIndividual)
        <livewire:servicio.pago-individual
            :id-factura="$idFacturaPago"
            :key="'pago-individual-'.$idFacturaPago"
        />
    @endif

    {{-- MODAL DE PAGO DE MESA --}}
    @if ($mostrarPagoMesa)
        <livewire:servicio.pago-mesa
            :id-mesa="$idMesaPago"
            :key="'pago-mesa-'.$idMesaPago"
        />
    @endif

</div>
