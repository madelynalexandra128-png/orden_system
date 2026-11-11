
<div>
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

                <!-- Todos -->
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

                <!-- Categorías disponibles -->
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

                        <!-- Imagen -->
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

                        <!-- Información -->
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

    </main>
</div>

