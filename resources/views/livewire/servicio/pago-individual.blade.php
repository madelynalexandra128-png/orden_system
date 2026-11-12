
<div>
    {{-- MODAL DE PAGO INDIVIDUAL --}}
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        wire:click.self="cerrar">

        <div class="w-full max-w-md overflow-hidden rounded-xl bg-white shadow-xl">

            {{-- ENCABEZADO --}}
            <div class="flex items-center justify-between border-b border-au-cream-border px-5 py-4">

                <div>
                    <h2 class="font-bold text-au-brown-dark">
                        Registrar pago
                    </h2>

                    <p class="text-xs text-au-text-muted">
                        Orden #{{ $idFactura }}
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="cerrar"
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-au-cream text-au-brown-dark hover:bg-au-cream-card">

                    <i class="fas fa-times"></i>
                </button>

            </div>

            {{-- CONTENIDO --}}
            <div class="space-y-4 p-5">

                {{-- TOTAL --}}
                <div class="rounded-xl bg-au-cream p-4 text-center">

                    <p class="text-xs text-au-text-muted">
                        Total de la orden
                    </p>

                    <p class="mt-1 text-2xl font-bold text-au-brown-dark">
                        ${{ number_format($totalPago, 0, ',', '.') }}
                    </p>

                </div>

                {{-- MÉTODO DE PAGO --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                        Método de pago
                    </label>

                    <select
                        wire:model.live="metodoPago"
                        class="w-full rounded-lg border border-au-cream-border bg-white px-3 py-2 text-sm focus:border-au-coral focus:outline-none">

                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Mixto">Mixto</option>

                    </select>
                </div>

                {{-- EFECTIVO --}}
                @if ($metodoPago === 'Efectivo')

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                            Efectivo recibido
                        </label>

                        <input
                            type="number"
                            min="0"
                            wire:model.live="montoRecibido"
                            class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm focus:border-au-coral focus:outline-none"
                            placeholder="Ingrese el valor recibido">

                        <div class="mt-3 flex items-center justify-between rounded-lg bg-au-cream p-3">

                            <span class="text-sm text-au-brown-dark">
                                Cambio a devolver
                            </span>

                            <span class="font-bold text-green-700">
                                ${{ number_format($this->calcularCambio(), 0, ',', '.') }}
                            </span>

                        </div>

                        @error('montoRecibido')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                @endif

                {{-- TARJETA --}}
                @if ($metodoPago === 'Tarjeta')

                    <div class="rounded-lg bg-au-cream p-3">
                        <p class="text-xs text-au-text-muted">
                            Valor a cobrar con tarjeta
                        </p>

                        <p class="font-bold text-au-brown-dark">
                            ${{ number_format($totalPago, 0, ',', '.') }}
                        </p>
                    </div>

                @endif

                {{-- TRANSFERENCIA --}}
                @if ($metodoPago === 'Transferencia')

                    <div class="rounded-lg bg-au-cream p-3">
                        <p class="text-xs text-au-text-muted">
                            Valor por transferencia
                        </p>

                        <p class="font-bold text-au-brown-dark">
                            ${{ number_format($totalPago, 0, ',', '.') }}
                        </p>
                    </div>

                @endif

                {{-- MIXTO --}}
                @if ($metodoPago === 'Mixto')

                    <div class="space-y-3">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                                Valor en efectivo
                            </label>

                            <input
                                type="number"
                                min="0"
                                wire:model.live="montoRecibido"
                                class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm focus:border-au-coral focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                                Segundo método
                            </label>

                            <select
                                wire:model.live="metodoMixto"
                                class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm">

                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Transferencia">Transferencia</option>

                            </select>
                        </div>

                        @if ($metodoMixto === 'Tarjeta')

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                                    Valor con tarjeta
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    wire:model.live="montoTarjeta"
                                    class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm">
                            </div>

                        @else

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-au-brown-dark">
                                    Valor por transferencia
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    wire:model.live="montoTransferencia"
                                    class="w-full rounded-lg border border-au-cream-border px-3 py-2 text-sm">
                            </div>

                        @endif

                        <div class="rounded-lg bg-au-cream p-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-au-text-muted">
                                    Total pagado
                                </span>

                                <span class="font-bold text-au-brown-dark">
                                    ${{ number_format(
                                        (float) $montoRecibido +
                                        ($metodoMixto === 'Tarjeta'
                                            ? (float) $montoTarjeta
                                            : (float) $montoTransferencia),
                                        0, ',', '.'
                                    ) }}
                                </span>
                            </div>
                        </div>

                    </div>

                @endif

                {{-- ERRORES --}}
                @error('pago')
                    <div class="rounded-lg bg-red-50 p-3 text-sm text-red-700">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-3 border-t border-au-cream-border p-4">

                <button
                    type="button"
                    wire:click="cerrar"
                    class="rounded-lg bg-au-text-muted px-4 py-2 text-sm font-semibold text-white hover:opacity-90">

                    Cancelar
                </button>

                <button
                    type="button"
                    wire:click="registrarPago"
                    wire:loading.attr="disabled"
                    wire:target="registrarPago"
                    class="rounded-lg bg-au-brown-dark px-4 py-2 text-sm font-semibold text-white hover:bg-au-brown-darkest">

                    <span wire:loading.remove wire:target="registrarPago">
                        <i class="fas fa-check mr-1"></i>
                        Confirmar pago
                    </span>

                    <span wire:loading wire:target="registrarPago">
                        Registrando...
                    </span>

                </button>

            </div>

        </div>
    </div>
</div>
