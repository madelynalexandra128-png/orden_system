
@extends('layouts.app')

@section('title', 'Barra')

@section('content')

<div class="min-h-screen bg-au-cream p-4 md:p-6">

    {{-- Encabezado --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-au-brown-darkest">
            Control de pedidos
        </h1>

        <p class="mt-1 text-sm text-au-text-muted">
            Administra los pedidos desde su llegada hasta su preparación.
        </p>
    </div>

    {{-- Tablero --}}
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[0.8fr_2fr]">

        {{-- PENDIENTES --}}
        <section class="self-start rounded-xl bg-yellow-50 p-3">

            <div class="mb-3 flex items-center justify-between">
                <h2 class="font-bold text-au-brown-darkest">
                    Pendientes
                </h2>

                <span class="rounded-full bg-yellow-200 px-3 py-1 text-sm font-bold text-yellow-800">
                    {{ $pedidos->where('estado', 'Pendiente')->count() }}
                </span>
            </div>

            @forelse ($pedidos->where('estado', 'Pendiente') as $pedido)

                <div class="mb-2 rounded-lg border border-au-cream-border bg-white p-2 shadow-sm">

                    <div class="flex items-center justify-between gap-2">

                        <h3 class="text-sm font-bold text-au-brown-darkest">
                            Pedido #{{ $pedido->id }}
                        </h3>

                        <span class="text-xs font-semibold text-yellow-700">
                            Pendiente
                        </span>

                    </div>

                    <div class="mt-1 flex items-center justify-between gap-2 text-xs">

                        <span class="text-au-text-muted">
                            {{ $pedido->mesa?->nombre ?? 'Sin mesa' }}
                        </span>

                        <span class="font-medium text-au-brown-dark">
                            {{ $pedido->detalleFactura->sum('cantidad') }} productos
                        </span>

                    </div>

                    <form
                        action="{{ route('barra.preparar', $pedido->id) }}"
                        method="POST"
                        class="mt-2"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="w-full rounded-md bg-au-coral px-2 py-1.5 text-xs font-semibold text-white transition hover:opacity-90"
                        >
                            Empezar preparación
                        </button>

                    </form>

                </div>

            @empty

                <p class="rounded-lg bg-white p-4 text-center text-sm text-au-text-muted">
                    No hay pedidos pendientes.
                </p>

            @endforelse

        </section>


        {{-- EN PREPARACIÓN --}}
        <section class="self-start rounded-xl bg-blue-50 p-3">

            <div class="mb-3 flex items-center justify-between">

                <h2 class="font-bold text-au-brown-darkest">
                    En preparación
                </h2>

                <span class="rounded-full bg-blue-200 px-3 py-1 text-sm font-bold text-blue-800">
                    {{ $pedidos->where('estado', 'En preparación')->count() }}
                </span>

            </div>

            {{-- Dos pedidos por fila --}}
            <div class="grid grid-cols-1 gap-3 xl:grid-cols-2">

                @forelse ($pedidos->where('estado', 'En preparación') as $pedido)

                    <div class="min-w-0 rounded-xl border border-au-cream-border bg-white p-3 shadow-sm">

                        {{-- Encabezado del pedido --}}
                        <div class="mb-3 flex items-center justify-between gap-2 border-b border-au-cream-border pb-2">

                            <h3 class="font-bold text-au-brown-darkest">
                                {{ $pedido->mesa?->nombre ?? 'Sin mesa' }}
                            </h3>

                            <span class="shrink-0 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                Pedido #{{ $pedido->id }}
                            </span>

                        </div>

                        {{-- Productos --}}
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">

                            @foreach ($pedido->detalleFactura as $detalle)

                                <div class="flex min-w-0 items-center gap-2 rounded-lg bg-au-cream p-2">

                                    {{-- Imagen --}}
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg bg-white">

                                        @if ($detalle->producto?->imagen)

                                            <img
                                                src="{{ asset('storage/' . $detalle->producto->imagen) }}"
                                                alt="{{ $detalle->producto->nombre }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-full items-center justify-center text-xs text-au-text-muted">
                                                Sin imagen
                                            </div>

                                        @endif

                                    </div>

                                    {{-- Información --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="wrap-break text-sm font-semibold text-au-brown-darkest">
                                            {{ $detalle->producto?->nombre ?? 'Producto no disponible' }}
                                        </p>

                                        <p class="mt-1 text-xs text-au-text-muted">
                                            Cantidad: {{ $detalle->cantidad }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- Botón --}}
                        <form
                            action="{{ route('barra.listo', $pedido->id) }}"
                            method="POST"
                            class="mt-3"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="w-full rounded-lg bg-au-coral px-4 py-2 font-semibold text-white transition hover:opacity-90"
                            >
                                Marcar como listo
                            </button>

                        </form>

                    </div>

                @empty

                    <p class="rounded-lg bg-white p-4 text-center text-sm text-au-text-muted xl:col-span-2">
                        No hay pedidos en preparación.
                    </p>

                @endforelse

            </div>

        </section>

    </div>

</div>

@endsection
