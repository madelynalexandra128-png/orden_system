@extends('layout.app')

@section('title')
    Crear factura
@endsection
@section('content')

{{-- Breadcrumb --}}   
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('factura.index') }}" class="hover:text-au-brown-dark">factura</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">Nueva factura</span>{{-- eesto es como que diga categoria/nueva categoria ubicandoo donde estamso  --}}
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Crear Producto</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-xl bg-white rounded-x1 border-b-au-brown-dark p-8">
            
            <form action ="{{ route('factura.store') }} "method='POST'>
                @csrf

                <div class="mb-6">

                    <label for ="idCliente" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Cliente
                    </label>

                    
                    <select  
                            id="idCliente"
                            name="idCliente"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">

                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">
                                        {{ $cliente->nombre }}
                                    </option>
                                    
                                @endforeach
                        </select>
                </div>


                <div class="mb-6">

                    <label for ="idMesa" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Mesa
                    </label>

                    
                    <select  
                            id="idMesa"
                            name="idMesa"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">

                                @foreach ($mesas as $mesa)
                                    <option value="{{ $mesa->id }}">
                                        {{ $mesa->nombre }}
                                    </option>
                                    
                                @endforeach
                        </select>
                </div>

                <div class="mb-6">

                    <label for ="metodoPago" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Metodo de Pago
                    </label>

    
                    <input 
                        type="text" 
                        id="metodoPago" 
                        name="metodoPago"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class="mb-6">

                    <label for ="metodoPago" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Estado
                    </label>

    
                    <input 
                        type="text" 
                        id="estado" 
                        name="estado"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>


                <div class="mb-6">

                    <label for ="fecha" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Fecha
                    </label>

    
                    <input 
                        type="date" 
                        id="fecha" 
                        name="fecha"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class="mb-6">

                    <label for ="total" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        TOTAL
                    </label>

                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-sm text-au-coral-text font-semibold">$</span>

                            <input 
                                type="number" 
                                id="total" 
                                name="total" 
                                class="w-full pl-6 pr-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                            >
                        </div>

                </div>


                <hr class="border-au-cream-border mb-6">

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('producto.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-au-cream-border bg-au-cream text-sm font-medium text-au-brown-darkest hover:bg-au-cream-border transition-all">
                        Cancelar
                    </a>

                    <button type="submit" 
                        class="px-5 py-2.5 rounded-lg bg-au-coral text-au-cream-card text-sm font-medium hover:opacity-90 active:scale-95 transition-all shadow-sm">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection