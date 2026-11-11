
<div>
    @if (!$pedidoConfirmado)
    @php
        $cantidadTotal = collect($pedido)->sum('cantidad');

        $totalPedido = collect($pedido)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });
    @endphp

    <!-- Encabezado -->
    <header class="bg-au-brown-darkest px-5 py-8 text-center">
        <h1 class="text-2xl font-bold text-white">
            Arcadia Urbana Café Bar
        </h1>

        <p class="mt-2 text-sm text-au-cream">
            MENÚ DIGITAL
        </p>

        <div class="mt-4 inline-block rounded-full bg-au-coral px-5 py-2">
            <span class="text-sm font-semibold text-white">
                {{ $mesa->nombre }}
            </span>
        </div>
    </header>

    <main class="mx-auto max-w-5xl space-y-6 px-4 py-6">

        <!-- Mensaje de pedido enviado -->
        @if (session()->has('pedidoEnviado'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                {{ session('pedidoEnviado') }}
            </div>
        @endif

        <!-- Buscador -->
        <div>
            <input
                type="search"
                wire:model.live.debounce.300ms="buscar"
                placeholder="Buscar productos..."
                class="w-full rounded-xl border border-au-cream-border bg-white px-4 py-3 outline-none focus:border-au-coral"
            >
        </div>

        <!-- Categorías -->
        <section>
            <h2 class="mb-4 text-lg font-bold text-au-brown-darkest">
                Categorías
            </h2>

            <div class="flex gap-3 overflow-x-auto pb-2">

                <button
                    type="button"
                    wire:click="seleccionarCategoria(null)"
                    class="shrink-0 rounded-full px-5 py-2 text-sm
                    {{ $categoriaSeleccionada === null
                        ? 'bg-au-brown-dark text-white'
                        : 'border border-au-cream-border bg-white text-au-brown-dark' }}"
                >
                    Todos
                </button>

                @foreach ($categorias as $categoria)
                    <button
                        type="button"
                        wire:key="categoria-{{ $categoria->id }}"
                        wire:click="seleccionarCategoria({{ $categoria->id }})"
                        class="shrink-0 rounded-full px-5 py-2 text-sm
                        {{ $categoriaSeleccionada == $categoria->id
                            ? 'bg-au-brown-dark text-white'
                            : 'border border-au-cream-border bg-white text-au-brown-dark' }}"
                    >
                        {{ $categoria->nombre }}
                    </button>
                @endforeach

            </div>
        </section>

        <!-- Productos -->
        <section>
            <h2 class="mb-4 text-lg font-bold text-au-brown-darkest">
                Nuestro menú
            </h2>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($productosFiltrados as $producto)

                    <article
                        wire:key="producto-{{ $producto->id }}"
                        class="overflow-hidden rounded-2xl border border-au-cream-border bg-white shadow-sm"
                    >

                        <div class="flex h-36 items-center justify-center bg-au-cream sm:h-44">

                            @if ($producto->imagen)
                                <img
                                    src="{{ asset('storage/' . $producto->imagen) }}"
                                    alt="{{ $producto->nombre }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <span class="text-sm text-au-text-muted">
                                    Sin imagen
                                </span>
                            @endif

                        </div>

                        <div class="space-y-3 p-3 sm:p-4">

                            <div>
                                <h3 class="font-bold text-au-brown-darkest">
                                    {{ $producto->nombre }}
                                </h3>

                                <p class="mt-1 text-sm text-au-text-muted">
                                    {{ $producto->descripcion }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2">

                                <span class="font-bold text-au-brown-dark">
                                    $ {{ number_format($producto->precio, 0, ',', '.') }}
                                </span>

                                <button
                                    type="button"
                                    wire:click="agregarProducto({{ $producto->id }})"
                                    class="rounded-lg bg-au-coral px-4 py-2 text-sm font-semibold text-white"
                                >
                                    Agregar
                                </button>

                            </div>

                        </div>
                    </article>

                @empty
                    <p class="col-span-full py-8 text-center text-au-text-muted">
                        No hay productos disponibles en este momento.
                    </p>
                @endforelse

            </div>
        </section>

        <!-- Errores -->
        @error('pedido')
            <div class="rounded-xl bg-red-50 p-3 text-sm text-red-700">
                {{ $message }}
            </div>
        @enderror

        <!-- Botón para revisar pedido -->
        <div class="sticky bottom-4 z-10">
            <button
                type="button"
                wire:click="verPedido"
                class="flex w-full items-center justify-between rounded-xl bg-au-brown-darkest px-5 py-4 font-semibold text-white shadow-lg"
            >
                <span>Ver mi pedido</span>

                <span class="rounded-full bg-au-coral px-3 py-1 text-sm">
                    {{ $cantidadTotal }} productos
                </span>
            </button>
        </div>

    </main>

    <!-- Resumen del pedido -->
    @if ($mostrarResumen)

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

            <div class="max-h-[85vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-5 shadow-xl">

                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-au-brown-darkest">
                        Mi pedido
                    </h2>

                    <button
                        type="button"
                        wire:click="volverAlMenu"
                        class="text-2xl text-au-text-muted"
                    >
                        &times;
                    </button>
                </div>

                @if (count($pedido) > 0)

                    <div class="space-y-4">

                        @foreach ($pedido as $idProducto => $item)

                            <div
                                wire:key="pedido-{{ $idProducto }}"
                                class="flex items-center gap-3 border-b border-au-cream-border pb-4"
                            >

                                <!-- Imagen del producto -->
                                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-au-cream">

                                    @if (!empty($item['imagen']))

                                        <img
                                            src="{{ asset('storage/' . $item['imagen']) }}"
                                            alt="{{ $item['nombre'] }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center text-xs text-au-text-muted">
                                            Sin imagen
                                        </div>

                                    @endif

                                </div>

                                <!-- Información -->
                                <div class="min-w-0 flex-1">

                                    <h3 class="font-semibold text-au-brown-darkest">
                                        {{ $item['nombre'] }}
                                    </h3>

                                    <p class="text-sm text-au-text-muted">
                                        {{ $item['cantidad'] }} unidades
                                    </p>

                                    <p class="font-bold text-au-brown-dark">
                                        $ {{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                                    </p>

                                </div>

                                <!-- Eliminar -->
                                <button
                                    type="button"
                                    wire:click="eliminarProducto({{ $idProducto }})"
                                    class="shrink-0 rounded-lg bg-red-50 p-2 text-red-600"
                                    title="Eliminar producto"
                                >
                                    <icon name="trash-2" />
                                </button>

                            </div>

                        @endforeach

                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <span class="font-semibold text-au-brown-darkest">
                            Total del pedido
                        </span>

                        <span class="text-xl font-bold text-au-brown-dark">
                            $ {{ number_format($totalPedido, 0, ',', '.') }}
                        </span>
                    </div>

                    @error('pedido')
                        <p class="mt-3 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <button
                        type="button"
                        wire:click="enviarPedido"
                        wire:loading.attr="disabled"
                        wire:target="enviarPedido"
                        class="mt-6 w-full rounded-xl bg-au-coral px-5 py-3 font-bold text-white disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="enviarPedido">
                            Enviar pedido
                        </span>

                        <span wire:loading wire:target="enviarPedido">
                            Enviando pedido...
                        </span>
                    </button>

                    <button
                        type="button"
                        wire:click="volverAlMenu"
                        class="mt-3 w-full rounded-xl border border-au-cream-border px-5 py-3 font-semibold text-au-brown-dark"
                    >
                        Seguir agregando productos
                    </button>

                @else

                    <p class="py-8 text-center text-au-text-muted">
                        Tu pedido está vacío.
                    </p>

                    <button
                        type="button"
                        wire:click="volverAlMenu"
                        class="w-full rounded-xl bg-au-brown-dark px-5 py-3 font-semibold text-white"
                    >
                        Volver al menú
                    </button>

                @endif

            </div>

        </div>

        @endif

    @else

    <!-- Confirmación del pedido -->
        <main class="flex min-h-screen items-center justify-center bg-au-cream px-4 py-8">

            <div class="w-full max-w-lg rounded-2xl border border-au-cream-border bg-white p-6 shadow-sm">

                <!-- Encabezado -->
                <div class="text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-9 w-9 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>

                    <h2 class="mt-4 text-2xl font-bold text-au-brown-darkest">
                        ¡Pedido enviado!
                    </h2>

                    <p class="mt-2 text-sm text-au-text-muted">
                        Tu pedido fue recibido correctamente.
                    </p>

                </div>

                <!-- Número y estado -->
                <div class="mt-6 rounded-xl bg-au-cream p-4 text-center">

                    <p class="text-sm text-au-text-muted">
                        Número de pedido
                    </p>

                    <p class="mt-1 text-2xl font-bold text-au-brown-darkest">
                        #{{ $pedidoConfirmado['numero'] }}
                    </p>

                    <span class="mt-3 inline-block rounded-full bg-au-coral px-4 py-1 text-sm font-semibold text-white">
                        {{ $pedidoConfirmado['estado'] }}
                    </span>

                    <p class="mt-2 text-sm text-au-text-muted">
                        Mesa: {{ $mesa->nombre }}
                    </p>

                </div>

                <!-- Productos solicitados -->
                <div class="mt-6">

                    <h3 class="mb-4 font-bold text-au-brown-darkest">
                        Productos solicitados
                    </h3>

                    <div class="space-y-4">

                        @foreach ($pedidoConfirmado['productos'] as $item)

                            <div class="flex items-center gap-3 border-b border-au-cream-border pb-3">

                                <!-- Imagen -->
                                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-au-cream">

                                    @if ($item['imagen'])

                                        <img
                                            src="{{ asset('storage/' . $item['imagen']) }}"
                                            alt="{{ $item['nombre'] }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center text-xs text-au-text-muted">
                                            Sin imagen
                                        </div>

                                    @endif

                                </div>

                                <!-- Información -->
                                <div class="min-w-0 flex-1">

                                    <p class="font-semibold text-au-brown-darkest">
                                        {{ $item['nombre'] }}
                                    </p>

                                    <p class="text-sm text-au-text-muted">
                                        {{ $item['cantidad'] }} unidades
                                    </p>

                                </div>

                                <!-- Subtotal -->
                                <p class="shrink-0 font-bold text-au-brown-dark">
                                    $ {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>

                <!-- Total -->
                <div class="mt-5 flex items-center justify-between border-t border-au-cream-border pt-4">

                    <span class="font-bold text-au-brown-darkest">
                        Total del pedido
                    </span>

                    <span class="text-xl font-bold text-au-brown-dark">
                        $ {{ number_format($pedidoConfirmado['total'], 0, ',', '.') }}
                    </span>

                </div>

                <p class="mt-5 text-center text-sm text-au-text-muted">
                    Gracias por tu pedido. Nuestro personal lo atenderá pronto.
                </p>

            </div>

        </main>

    @endif

</div>
