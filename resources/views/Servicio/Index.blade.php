
@extends('layouts.app')

@section('title', 'Servicio')

@section('content')

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
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Columnas --}}
    <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-2">

        {{-- POR ENTREGAR --}}
        <div class="rounded-xl border border-au-cream-border bg-white p-4 shadow-sm">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-au-brown-dark">
                    Por entregar
                </h2>

                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    {{ $pedidosListos->count() }}
                </span>
            </div>

            <div class="space-y-4">

                @forelse ($pedidosListos as $pedido)

                    <div class="rounded-xl border border-au-cream-border p-4">

                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="font-bold text-au-brown-dark">
                                Pedido #{{ $pedido->id }}
                            </h3>

                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Listo
                            </span>
                        </div>

                        <p class="mb-3 text-sm text-au-text-muted">
                            {{ $pedido->mesa?->nombre ?? 'Sin mesa' }}
                        </p>

                        <div class="space-y-2">

                            @foreach ($pedido->detalleFactura as $detalle)

                                <div class="flex items-center justify-between rounded-lg bg-au-cream p-3">

                                    <span class="text-sm text-au-brown-dark">
                                        {{ $detalle->producto?->nombre ?? 'Producto no disponible' }}
                                    </span>

                                    <span class="text-sm font-semibold text-au-brown-dark">
                                        x{{ $detalle->cantidad }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                        <div class="mt-3 text-sm text-au-text-muted">
                            Total de productos:
                            <strong>
                                {{ $pedido->detalleFactura->sum('cantidad') }}
                            </strong>
                        </div>

                        <form action="{{ route('servicio.entregar', $pedido->id) }}"
                              method="POST"
                              class="mt-4">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                class="w-full rounded-lg bg-au-brown-dark px-4 py-2 font-semibold text-white transition hover:bg-au-brown-darkest">

                                Entregar pedido

                            </button>

                        </form>

                    </div>

                @empty

                    <div class="rounded-lg bg-au-cream p-6 text-center">
                        <p class="font-medium text-au-brown-dark">
                            No hay pedidos por entregar.
                        </p>

                        <p class="mt-1 text-sm text-au-text-muted">
                            Aquí aparecerán los pedidos que Barra marque como listos.
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

            <div class="space-y-3">

                @forelse ($pedidosEntregados as $pedido)

                    <div class="rounded-xl border border-au-cream-border p-4">

                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm text-au-text-muted">
                                Mesa
                            </span>

                            <span class="font-semibold text-au-brown-dark">
                                {{ $pedido->mesa?->nombre ?? 'Sin mesa' }}
                            </span>
                        </div>

                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm text-au-text-muted">
                                Orden
                            </span>

                            <span class="font-semibold text-au-brown-dark">
                                #{{ $pedido->id }}
                            </span>
                        </div>

                        <div class="mb-4 flex items-center justify-between border-t border-au-cream-border pt-3">
                            <span class="text-sm font-medium text-au-brown-dark">
                                Total
                            </span>

                            <span class="text-lg font-bold text-au-brown-dark">
                                ${{ number_format($pedido->total, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button"
                            class="w-full rounded-lg bg-au-brown-dark px-4 py-2 font-semibold text-white transition hover:bg-au-brown-darkest">

                            Pagar

                        </button>

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

</div>

@endsection
