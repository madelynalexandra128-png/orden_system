
<div
    class="bg-white rounded-xl shadow-sm border border-au-cream-border overflow-hidden"
    x-data
    x-on:producto-seleccionado.window="$nextTick(() => $refs.cantidad.focus())"
>

    {{-- ======================================
    BUSCADOR, CANTIDAD Y BOTÓN AGREGAR
    ======================================= --}}

    <div class="p-4 flex flex-col sm:flex-row gap-3 border-b border-au-cream-border bg-au-cream">

        {{-- BUSCADOR DE PRODUCTOS --}}
        <div class="flex-1 relative">

            <input
                type="text"
                wire:model.live.debounce.300ms="buscar"
                placeholder="Buscar producto..."
                class="w-full px-4 py-2.5 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
            >

            {{-- RESULTADOS DE LA BÚSQUEDA --}}
            @if (trim($buscar) != '' && !$productoSeleccionado)

                <div class="absolute top-full left-0 w-full bg-white border border-au-cream-border rounded-lg shadow-lg z-30 max-h-64 overflow-y-auto">

                    @forelse ($productos as $producto)

                        {{-- PRODUCTO ENCONTRADO --}}
                        <button
                            type="button"
                            wire:key="resultado-{{ $producto->id }}"
                            wire:click="seleccionarProducto({{ $producto->id }})"
                            class="w-full flex items-center gap-3 p-3 text-left hover:bg-au-cream border-b border-au-cream-border"
                        >

                            {{-- IMAGEN DEL PRODUCTO --}}
                            @if ($producto->imagen)

                                <img
                                    src="{{ asset('img/' . $producto->imagen) }}"
                                    alt="{{ $producto->nombre }}"
                                    class="w-12 h-12 object-cover rounded-lg"
                                >

                            @endif

                            {{-- NOMBRE Y PRECIO --}}
                            <div class="flex-1">

                                <p class="text-sm font-semibold text-au-brown-darkest">
                                    {{ $producto->nombre }}
                                </p>

                                <p class="text-sm text-au-coral-text">
                                    ${{ number_format($producto->precio, 0, ',', '.') }}
                                </p>

                            </div>

                            {{-- STOCK DISPONIBLE --}}
                            <span class="text-xs text-au-text-muted">
                                Stock: {{ $producto->stock }}
                            </span>

                        </button>

                    @empty

                        {{-- MENSAJE CUANDO NO HAY RESULTADOS --}}
                        <p class="p-3 text-sm text-au-text-muted text-center">
                            No se encontraron productos.
                        </p>

                    @endforelse

                </div>

            @endif

        </div>


        {{-- ======================================
        SELECTOR DE CANTIDAD
        ======================================= --}}

        <div class="flex items-center gap-2">

            <label
                for="cantidad"
                class="text-sm font-semibold text-au-brown-darkest"
            >
                Cant.
            </label>

            <select
                id="cantidad"
                x-ref="cantidad"
                wire:model="cantidad"
                wire:keydown.enter.prevent="agregarProducto"
                class="sm:w-24 px-4 py-2.5 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral"
            >

                {{-- MOSTRAR CANTIDADES SEGÚN EL STOCK --}}
                @if ($productoSeleccionado)

                    @for (
                        $i = 1;
                        $i <= min(10, $productoSeleccionado['stock']);
                        $i++
                    )

                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>

                    @endfor

                @else

                    <option value="1">1</option>

                @endif

            </select>

        </div>


        {{-- ======================================
        BOTÓN AGREGAR
        ======================================= --}}

        <button
            type="button"
            wire:click="agregarProducto"
            @disabled(!$productoSeleccionado)
            class="px-5 py-2.5 rounded-lg bg-au-brown-dark text-au-cream text-sm font-medium hover:bg-au-brown-darkest active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
        >
            + Agregar
        </button>

    </div>


    {{-- ======================================
    TABLA DE PRODUCTOS DE LA FACTURA
    ======================================= --}}

    <div class="overflow-x-auto">

        <table class="w-full text-left">

            {{-- ENCABEZADOS --}}
            <thead class="text-xs text-au-text-muted bg-au-cream/50">

                <tr>

                    <th class="px-4 py-3 font-semibold">
                        Producto
                    </th>

                    <th class="px-4 py-3 font-semibold text-right">
                        Precio
                    </th>

                    <th class="px-4 py-3 font-semibold text-center">
                        Cantidad
                    </th>

                    <th class="px-4 py-3 font-semibold text-right">
                        Subtotal
                    </th>

                    <th class="px-4 py-3"></th>

                </tr>

            </thead>


            {{-- CUERPO DE LA TABLA --}}
            <tbody class="divide-y divide-au-cream-border text-sm">

                @forelse ($productosFactura as $id => $item)

                    <tr wire:key="producto-factura-{{ $id }}">

                        {{-- NOMBRE --}}
                        <td class="px-4 py-3 font-medium text-au-brown-darkest">
                            {{ $item['nombre'] }}
                        </td>

                        {{-- PRECIO UNITARIO --}}
                        <td class="px-4 py-3 text-right">
                            ${{ number_format($item['precioUnitario'], 0, ',', '.') }}
                        </td>

                        {{-- CANTIDAD --}}
                        <td class="px-4 py-3 text-center">
                            {{ $item['cantidad'] }}
                        </td>

                        {{-- SUBTOTAL --}}
                        <td class="px-4 py-3 text-right font-semibold">
                            ${{ number_format($item['total'], 0, ',', '.') }}
                        </td>

                        {{-- ELIMINAR --}}
                        <td class="px-4 py-3 text-right">

                            <button
                                type="button"
                                wire:click="eliminarProducto({{ $id }})"
                                class="text-au-coral hover:underline"
                            >
                                Eliminar
                            </button>

                        </td>

                    </tr>

                @empty

                    {{-- MENSAJE CUANDO LA FACTURA ESTÁ VACÍA --}}
                    <tr>

                        <td
                            colspan="5"
                            class="py-16 text-center text-sm text-au-text-muted"
                        >
                            Aún no hay productos. Búscalos arriba.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ======================================
    CAMPOS OCULTOS PARA ENVIAR LOS PRODUCTOS
    ======================================= --}}

    @foreach ($productosFactura as $id => $item)

        <input
            type="hidden"
            name="productos[{{ $id }}][idProducto]"
            value="{{ $item['idProducto'] }}"
        >

        <input
            type="hidden"
            name="productos[{{ $id }}][cantidad]"
            value="{{ $item['cantidad'] }}"
        >

        <input
            type="hidden"
            name="productos[{{ $id }}][precioUnitario]"
            value="{{ $item['precioUnitario'] }}"
        >

        <input
            type="hidden"
            name="productos[{{ $id }}][total]"
            value="{{ $item['total'] }}"
        >

    @endforeach


    {{-- ======================================
    PIE DE LA TABLA
    ======================================= --}}

    <div class="px-4 py-3 flex items-center justify-between border-t border-au-cream-border bg-au-cream/50">

        {{-- CANTIDAD DE PRODUCTOS DIFERENTES --}}
        <span class="text-sm text-au-brown-darkest">

            <b>{{ count($productosFactura) }}</b>
            artículos seleccionados

        </span>

        {{-- VACIAR LISTA --}}
        <button
            type="button"
            wire:click="vaciarLista"
            class="text-sm font-medium text-au-coral hover:underline"
        >
            Vaciar lista
        </button>

    </div>

</div>
