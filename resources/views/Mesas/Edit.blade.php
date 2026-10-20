@extends('layout.app')
@section('title')
    Mesa
@endsection

@section('content')



{{-- Breadcrumb --}}   
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('mesa.index') }}" class="hover:text-au-brown-dark">Mesas</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">Nuevo Producto</span>{{-- eesto es como que diga categoria/nueva categoria ubicandoo donde estamso  --}}
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Crear Producto</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-xl bg-white rounded-x1 border-b-au-brown-dark p-8">
            
            <form action ="{{ route('mesa.update',$mesas->id) }} "method='POST'>
                
                @csrf
                @method('PUT')

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Nombre de la mesa
                    </label>

    
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre"
                        value="{{$mesas->nombre}}"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>


                <div class="w-1/2">
                        
                    <label for ="Precio De compra" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Capacidad
                    </label>

                        <input 
                            type="number" 
                            id="capacidad" 
                            name="capacidad" 
                            value="{{ $mesas->capacidad }}"
                            class="w-full pl-6 pr-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                            >
                </div>

                <div class="mb-6">

                    <label for ="estado" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Estado
                    </label>

    
                    <input 
                        type="text" 
                        id="estado" 
                        name="estado"
                        value="{{ $mesas->estado }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        QR
                    </label>

    
                    <input 
                        type="text" 
                        id="codigoQr" 
                        name="codigoQr"
                        value="{{ $mesas->codigoQr }}"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <hr class="border-au-cream-border mb-6">

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('mesa.index') }}"
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