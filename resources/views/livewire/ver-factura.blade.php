
<div>
    {{-- Botón del ojo --}}
    <button
        type="button"
        wire:click="abrirModal"
        title="Ver factura"
        class="inline-flex items-center justify-center p-2 rounded-lg
               text-au-brown-dark hover:bg-au-cream hover:text-au-coral
               transition duration-200"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.8">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M2.25 12s3.75-7.5 9.75-7.5
                   9.75 7.5 9.75 7.5
                   -3.75 7.5-9.75 7.5
                   S2.25 12 2.25 12Z" />

            <circle cx="12" cy="12" r="3" />
        </svg>
    </button>

    {{-- Modal --}}
    @if ($mostrarModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center
                   bg-black/50 p-4"
            wire:click.self="cerrarModal"
        >

            <div class="w-full max-w-2xl overflow-hidden rounded-xl
                        bg-white border border-gray-100 shadow-2xl">

                {{-- Encabezado --}}
                <div class="flex items-center justify-between
                            bg-au-text-muted px-6 py-4 text-white">

                    <div>
                        <h2 class="text-xl font-bold">
                            Factura #{{ $factura->id }}
                        </h2>

                        <p class="text-sm text-white/90">
                            Detalle de la factura
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="cerrarModal"
                        class="text-2xl text-white hover:text-au-brown-darkest transition"
                    >
                        &times;
                    </button>
                </div>

                {{-- Contenido --}}
                <div class="max-h-[70vh] space-y-5 overflow-y-auto p-6">

                    {{-- Información de la factura --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-sm font-semibold text-au-brown-dark">
                                Fecha
                            </p>
                            <p class="font-semibold text-au-brown-darkest">
                                {{ $factura->fecha }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-au-brown-dark">
                                Estado
                            </p>
                            <p class="font-semibold text-au-brown-darkest">
                                {{ $factura->estado }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-au-brown-dark">
                                Cliente
                            </p>
                            <p class="font-semibold text-au-brown-darkest">
                                {{ $factura->cliente?->nombre ?? 'No disponible' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-au-brown-dark">
                                Mesa
                            </p>
                            <p class="font-semibold text-au-brown-darkest">
                                {{ $factura->idMesa }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-au-brown-dark">
                                Método de pago
                            </p>
                            <p class="font-semibold text-au-brown-darkest">
                                {{ $factura->metodoPago }}
                            </p>
                        </div>

                    </div>

                    <hr class="border-gray-100">

                    {{-- Productos --}}
                    <h3 class="font-bold text-au-brown-darkest">
                        Productos
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">

                            <thead class="bg-au-cream text-au-brown-darkest">
                                <tr>
                                    <th class="p-3">Producto</th>
                                    <th class="p-3">Cantidad</th>
                                    <th class="p-3">Precio</th>
                                    <th class="p-3">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($factura->detalleFactura as $detalle)
                                    <tr class="border-b border-gray-100">

                                        <td class="p-3 text-au-brown-darkest">
                                            {{ $detalle->producto?->nombre ?? 'No disponible' }}
                                        </td>

                                        <td class="p-3 text-au-brown-darkest">
                                            {{ $detalle->cantidad }}
                                        </td>

                                        <td class="p-3 text-au-brown-darkest">
                                            ${{ number_format($detalle->precioUnitario, 0, ',', '.') }}
                                        </td>

                                        <td class="p-3 text-au-brown-darkest">
                                            ${{ number_format($detalle->total, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    {{-- Total --}}
                    <div class="flex items-center justify-between
                                border-t border-gray-100 pt-4">

                        <span class="text-lg font-bold text-au-brown-dark">
                            Total
                        </span>

                        <span class="text-2xl font-extrabold
                                     text-au-brown-darkest">
                            ${{ number_format($factura->total, 0, ',', '.') }}
                        </span>

                    </div>

                </div>

                {{-- Pie del modal --}}
                <div class="flex justify-end bg-au-cream p-4">

                    <button
                        type="button"
                        wire:click="cerrarModal"
                        class="rounded-lg bg-au-text-muted
                               px-5 py-2 text-white
                               hover:opacity-90 transition"
                    >
                        Cerrar
                    </button>

                </div>

            </div>
        </div>
    @endif
</div>
