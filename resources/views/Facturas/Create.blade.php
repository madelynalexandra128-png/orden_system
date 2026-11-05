@extends('layouts.app')

@section('title')
    Crear factura
@endsection

@section('content')

    {{-- Breadcrumb --}}
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('factura.index') }}" class="hover:text-au-brown-dark">factura</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">Nueva factura</span>
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Nueva factura</h1>

    <div class="w-full max-w-7xl mx-auto">
        <form action="{{ route('factura.store') }}" method="POST"
            class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-6 items-start">
            @csrf

            {{-- ============ COLUMNA IZQUIERDA: PRODUCTOS ============ --}}
            <section class="bg-white rounded-xl shadow-sm border border-au-cream-border overflow-hidden">

                {{-- Buscador + selector + agregar --}}
                <div class="p-4 flex flex-col sm:flex-row gap-3 border-b border-au-cream-border bg-au-cream">
                    <input type="text" placeholder="Buscar producto..."
                        class="flex-1 px-4 py-2.5 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">

                    {{-- Cantidad --}}
                    <div class="flex items-center gap-2">
                        <label for="cantidad" class="text-sm font-semibold text-au-brown-darkest">Cant.</label>
                        <select id="cantidad"
                                class="sm:w-24 px-4 py-2.5 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral">
                        </select>
                    </div>

                    <button type="button"
                            class="px-5 py-2.5 rounded-lg bg-au-brown-dark text-au-cream text-sm font-medium hover:bg-au-brown-darkest active:scale-95 transition-all">
                        + Agregar
                    </button>
                </div>

                {{-- Tabla de productos --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-xs text-au-text-muted bg-au-cream/50">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Producto</th>
                                <th class="px-4 py-3 font-semibold text-right">Precio</th>
                                <th class="px-4 py-3 font-semibold text-center">Cantidad</th>
                                <th class="px-4 py-3 font-semibold text-right">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-au-cream-border text-sm">

                            {{-- Fila de ejemplo (luego se repite con @foreach) --}}
                            
                        </tbody>
                    </table>

                    {{-- Estado vacío (mostrar solo cuando no haya productos) --}}
                    {{-- <p class="py-16 text-center text-sm text-au-text-muted">Aún no hay productos. Búscalos arriba o usa los accesos rápidos.</p> --}}
                </div>

                {{-- Pie: contador + vaciar --}}
                <div class="px-4 py-3 flex items-center justify-between border-t border-au-cream-border bg-au-cream/50">
                    <span class="text-sm text-au-brown-darkest"><b></b> artículos seleccionados</span>
                    <button type="button" class="text-sm font-medium text-au-coral hover:underline">Vaciar lista</button>
                </div>

                {{-- Accesos rápidos --}}
                <div class="px-4 py-3 flex flex-wrap items-center gap-2 border-t border-au-cream-border">
                    <span class="text-sm text-au-text-muted mr-1">Rápidos:</span>
                    
            </section>

            {{-- ============ COLUMNA DERECHA ============ --}}
            <aside class="space-y-4 lg:sticky lg:top-4">

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

                {{-- Método de pago (radios con estilo: se marcan solos, sin JavaScript) --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4">
                    <p class="text-sm font-semibold text-au-brown-darkest mb-2">Método de pago</p>

                    <div class="grid grid-cols-2 gap-2">
                        @foreach (['Efectivo', 'Tarjeta', 'Transferencia', 'Mixto'] as $metodo)
                            <label class="cursor-pointer">
                                <input type="radio" name="metodoPago" value="{{ $metodo }}" class="peer sr-only"
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

                    <div class="mt-3 rounded-lg bg-au-cream p-3 text-sm text-au-brown-darkest space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <span>Monto recibido</span>
                            <input type="number" placeholder="0"
                                class="w-28 px-2 py-1 rounded-md bg-white border border-au-cream-border text-right focus:outline-none focus:ring-2 focus:ring-au-coral">
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Cambio / Vuelto</span>
                            <b class="text-au-text-muted">$0</b>
                        </div>
                    </div>
                </div>

                {{-- Totales --}}
                <div class="bg-white rounded-xl shadow-sm border border-au-cream-border p-4 space-y-2 text-sm text-au-brown-darkest">
                    <div class="flex justify-between"><span>Subtotal</span><b>$38.500</b></div>
                    <div class="flex justify-between"><span>Impuesto (19%)</span><b>$7.315</b></div>

                    <div class="flex justify-between items-center border-t border-au-cream-border pt-3 mt-2">
                        <label for="total" class="font-semibold">Total a pagar</label>

                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-2xl text-au-coral-text font-semibold">$</span>
                            <input type="number" id="total" name="total" value="45815" readonly
                                class="w-44 pl-8 pr-2 py-1 bg-transparent text-right text-3xl font-extrabold text-au-brown-darkest focus:outline-none">
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
            </aside>
        </form>
    </div>
@endsection