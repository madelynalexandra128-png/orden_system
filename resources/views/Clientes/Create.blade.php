@extends('layout.app')
@section('title')
    Cliente
@endsection

@section('content')

{{-- Breadcrumb --}}   
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('cliente.index') }}" class="hover:text-au-brown-dark">Cliente</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">Nuevo cliente</span>{{-- eesto es como que diga categoria/nueva categoria ubicandoo donde estamso  --}}
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Crear Cliente</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-xl bg-white rounded-x1 border-b-au-brown-dark p-8">
            
            <form action ="{{ route('cliente.store') }} "method='POST' enctype="multipart/form-data">
                @csrf

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Nombre 
                    </label>

                    {{-- nombre del producto  --}}
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="nombre" {{-- identificar el canpoe en html --}}
                        name="nombre" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('nombre') }}"{{-- valor anterio --}}
                        placeholder="madelyn "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Apellido
                    </label>

                    
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="apellido" {{-- identificar el canpoe en html --}}
                        name="apellido" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('apellido') }}"{{-- valor anterio --}}
                        placeholder="Becerra "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>


                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Cedula
                    </label>

                    
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="cedula" {{-- identificar el canpoe en html --}}
                        name="cedula" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('cedula') }}"{{-- valor anterio --}}
                        placeholder="Becerra "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>



                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        N° Telefono
                    </label>

                    
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="telefono" {{-- identificar el canpoe en html --}}
                        name="telefono" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('telefono') }}"{{-- valor anterio --}}
                        placeholder="Becerra "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Correo Electronico
                    </label>

                    
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="correo" {{-- identificar el canpoe en html --}}
                        name="correo" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('correo') }}"{{-- valor anterio --}}
                        placeholder="madelynbecerra@gmail.com "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>

                <div class=" mb-6">

                    <label for="puntos"
                        class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Puntos
                    </label>

                    <input
                        type="number"
                        id="puntos"
                        name="puntos"
                        value="{{ old('puntos') }}"
                        placeholder="10"
                        min="0"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                    >

                </div>




                <hr class="border-au-cream-border mb-6">

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('cliente.index') }}"
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
    </div


@endsection