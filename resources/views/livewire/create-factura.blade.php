
<div>
    <form action="{{ route('factura.store') }}" method="POST" class="w-full">

        @csrf

        <div class="w-full grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_380px] gap-6 items-start">

            {{-- ============ COLUMNA IZQUIERDA: PRODUCTOS ============ --}}
            <section class="bg-white rounded-xl shadow-sm border border-au-cream-border overflow-hidden">

                <livewire:factura-buscar />

            </section>

            {{-- ============ COLUMNA DERECHA ============ --}}
            <div class="space-y-4 lg:sticky lg:top-4">

                {{-- Cliente --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4">

                    <label for="idCliente" class="block text-sm font-semibold text-au-brown-darkest mb-2">
                        Cliente
                    </label>

                    <select id="idCliente" name="idCliente"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral">

                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Mesa, estado y fecha --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4 grid grid-cols-2 gap-3">

                    <div>
                        <label for="idMesa" class="block text-sm font-semibold text-au-brown-darkest mb-2">
                            Mesa
                        </label>

                        <select id="idMesa" name="idMesa"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral">

                            @foreach ($mesas as $mesa)
                                <option value="{{ $mesa->id }}">
                                    {{ $mesa->nombre }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-semibold text-au-brown-darkest mb-2">
                            Estado
                        </label>

                        <select id="estado" name="estado"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral">

                            <option value="pendiente">Pendiente</option>
                            <option value="pagada">Pagada</option>
                            <option value="anulada">Anulada</option>

                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="fecha" class="block text-sm font-semibold text-au-brown-darkest mb-2">
                            Fecha
                        </label>

                        <input type="date" id="fecha" name="fecha"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral">
                    </div>

                </div>

                {{-- Método de pago --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4">

                    <p class="text-sm font-semibold text-au-brown-darkest mb-2">
                        Método de pago
                    </p>

                    <div class="grid grid-cols-2 gap-2">

                        @foreach (['Efectivo', 'Tarjeta', 'Transferencia', 'Mixto'] as $metodo)

                            <label class="cursor-pointer">

                                <input type="radio" name="metodoPago" value="{{ $metodo }}" wire:model.live="metodoPago" class="peer sr-only"
                                    {{ $loop->first ? 'checked' : '' }}>

                                <span class="block text-center px-3 py-2.5 rounded-lg border border-au-cream-border bg-white text-sm font-semibold text-au-brown-darkest transition-all
                                    hover:bg-au-cream
                                    peer-checked:bg-au-brown-dark peer-checked:border-au-brown-dark peer-checked:text-au-cream
                                    peer-focus-visible:ring-2 peer-focus-visible:ring-au-coral">

                                    {{ $metodo }}

                                </span>

                            </label>

                        @endforeach

                    </div>

                {{-- CAMPOS DE PAGO --}}
                    @if ($metodoPago === 'Efectivo')

                        <div class="mt-3 rounded-lg bg-au-cream p-3 text-sm text-au-brown-darkest space-y-2">

                            <div class="flex items-center justify-between gap-3">
                                <span>Monto recibido</span>

                                <input
                                    type="number"
                                    name="montoRecibido"
                                    wire:model.live="montoRecibido"
                                    placeholder="0"
                                    class="w-28 px-2 py-1 rounded-md bg-white border border-au-cream-border text-right focus:outline-none focus:ring-2 focus:ring-au-coral">
                            </div>

                            <div class="flex items-center justify-between">
                                <span>Cambio / Vuelto</span>
                                <b class="text-au-text-muted">
                                    ${{ number_format($this->calcularCambio(), 0, ',', '.') }}
                                </b>
                            </div>

                        </div>

                    @elseif ($metodoPago === 'Mixto')

                        <div class="mt-3 rounded-lg bg-au-cream p-3 text-sm text-au-brown-darkest space-y-3">

                            <div class="flex items-center justify-between gap-3">
                                <span>Monto recibido en efectivo</span>

                                <input
                                    type="number"
                                    name="montoRecibido"
                                    wire:model.live="montoRecibido"
                                    placeholder="0"
                                    class="w-28 px-2 py-1 rounded-md bg-white border border-au-cream-border text-right">
                            </div>

                            <div>
                                <label class="block mb-1">Segundo método de pago</label>

                                <select
                                    name="metodoMixto"
                                    wire:model.live="metodoMixto"
                                    class="w-full px-2 py-2 rounded-md bg-white border border-au-cream-border">

                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>

                                </select>
                            </div>

                            @if ($metodoMixto === 'Tarjeta')

                                <div class="flex items-center justify-between gap-3">
                                    <span>Monto recibido por tarjeta</span>

                                    <input
                                        type="number"
                                        name="montoTarjeta"
                                        wire:model.live="montoTarjeta"
                                        placeholder="0"
                                        class="w-28 px-2 py-1 rounded-md bg-white border border-au-cream-border text-right">
                                </div>

                            @else

                                <div class="flex items-center justify-between gap-3">
                                    <span>Monto recibido por transferencia</span>

                                    <input
                                        type="number"
                                        name="montoTransferencia"
                                        wire:model.live="montoTransferencia"
                                        placeholder="0"
                                        class="w-28 px-2 py-1 rounded-md bg-white border border-au-cream-border text-right">
                                </div>

                            @endif

                            <div class="flex items-center justify-between border-t border-au-cream-border pt-2">
                                <span>Cambio / Vuelto</span>
                                <b class="text-au-text-muted">
                                    ${{ number_format($this->calcularCambio(), 0, ',', '.') }}
                                </b>
                            </div>

                        </div>

                    @endif

                    </div>

                </div>

                {{-- Puntos y total --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4 space-y-4">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full bg-au-cream flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-au-coral"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3l2.5 5.5L20 9l-4 4 1 5.5-5-2.8-5 2.8L8 13 4 9l5.5-.5L12 3z"/>

                                </svg>

                            </div>

                            <div>
                                <p class="text-sm font-semibold text-au-brown-darkest">
                                    Puntos ganados
                                </p>

                                <p class="text-xs text-au-text-muted">
                                    Por los productos de esta factura
                                </p>
                            </div>

                        </div>

                        <span class="text-xl font-bold text-au-coral">
                            {{ number_format($totalPuntos, 0, ',', '.') }}
                        </span>

                    </div>

                    {{-- Total a pagar --}}
                    <div class="flex justify-between items-center border-t border-au-cream-border pt-4">

                        <label for="total" class="font-semibold text-au-brown-darkest">
                            Total a pagar
                        </label>

                        <div class="relative flex items-center">

                            <span class="absolute left-3 text-2xl text-au-coral-text font-semibold">$</span>

                            <input
                                type="text"
                                id="total"
                                name="total"
                                value="{{ number_format($totalFactura, 0, ',', '.') }}"
                                readonly
                                class="w-44 pl-8 pr-2 py-1 bg-transparent text-right text-3xl font-extrabold text-au-brown-darkest focus:outline-none"
                            >

                        </div>

                    </div>

                </div>

                {{-- Acciones --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('factura.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-au-cream-border bg-au-cream text-sm font-medium text-au-brown-darkest hover:bg-au-cream-border transition-all">

                        Cancelar

                    </a>

                    <button type="submit"
                        class="flex-1 px-5 py-2.5 rounded-lg bg-au-coral text-au-cream-card text-sm font-medium hover:opacity-90 active:scale-95 transition-all shadow-sm">

                        Guardar

                    </button>

                </div>

            </div>

        </div>

    </form>
</div>
