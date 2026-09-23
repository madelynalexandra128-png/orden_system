@extends('layout.app')

@section('title')
        Productos
@endsection
@section('content')

{{-- Breadcrumb --}}   
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('producto.index') }}" class="hover:text-au-brown-dark">Producto</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">Nuevo Producto</span>{{-- eesto es como que diga categoria/nueva categoria ubicandoo donde estamso  --}}
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Crear categoría</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-xl bg-white rounded-x1 border-b-au-brown-dark p-8">
            
            <form action ="{{ route('producto.store') }} "method='POST' enctype="multipart/form-data">
                @csrf

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Nombre del Producto
                    </label>

                    {{-- nombre del producto  --}}
                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="nombre" {{-- identificar el canpoe en html --}}
                        name="nombre" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('nombre') }}"{{-- valor anterio --}}
                        placeholder="Ej: cafe "{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>


                {{-- descripcion  --}}
                <div class="mb-6">

                    <label for ="Descripcion" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Descripcion
                    </label>

                    <textarea 
                        id="descripcion" {{-- identificar el canpoe en html --}}
                        name="descripcion"
                        rows="3" {{-- nombre del dato que recibe laravel --}}
                        value="{{ old('descripcion') }}"{{-- valor anterio --}}
                        placeholder="Ej:Café 100% colombiano, café molido y notas aromáticas naturales de vainilla."{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                        ></textarea>
                </div>

                <div class="flex justify-between items-center w-full mb-6 gap-4">

                    {{-- PRECIO DE COMPRA  --}}
                    <div class="w-1/2">
                        
                        <label for ="Precio De compra" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Preiso de compra
                        </label>

                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-sm text-au-coral-text font-semibold">$</span>

                            <input 
                                type="number" 
                                id="precioCompra" 
                                name="precioCompra" 
                                value="{{ old('precioCompra') }}"
                                placeholder=" 5000"
                                class="w-full pl-6 pr-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                            >
                        </div>

                    </div>

                    {{-- PRECIO DE VENTA  --}}

                    <div class="w-1/2">

                        <label for ="Precio" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Preiso de venta
                        </label>

                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-sm text-au-coral-text font-semibold">$</span>

                            <input 
                                type="number" 
                                id="precio" 
                                name="precio" 
                                value="{{ old('precio') }}"
                                placeholder="8000"
                                class="w-full pl-6 pr-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                            >
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center w-full mb-6 gap-4">

                    <!-- STOCK-->
                    <div class="w-1/2">

                        <label for="stock"
                            class="block text-sm font-semibold text-au-brown-darkest mb-2">
                            Stock
                        </label>

                        <input
                            type="number"
                            id="stock"
                            name="stock"
                            value="{{ old('stock') }}"
                            placeholder="Ej: 20"
                            min="0"  
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                        >

                    </div>


                    <!-- PUNTOS-->
                    <div class="w-1/2">

                        <label for="puntos"
                            class="block text-sm font-semibold text-au-brown-darkest mb-2">
                            Puntos
                        </label>

                        <input
                            type="number"
                            id="puntos"
                            name="puntos"
                            value="{{ old('puntos') }}"
                            placeholder="Ej: 10"
                            min="0"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                        >

                    </div>

                </div>


                <div class="flex justify-between items-center w-full mb-6 gap-4">

                    <div class="w-1/2">
                        <label class="block text-ms font-semibold text-au-brown-darkest mb-2">
                            Categoría
                        </label>

                        <select  id="idCategoria"
                            name="idCategoria"
                            value="{{ old('idCategoria') }}"
                            class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">

                                @foreach ($categoria as $categoria)
                                    <option value="{{ $categoria->id }}">
                                        {{ $categoria->nombre }}
                                    </option>
                                    
                                @endforeach
                        </select>
                    </div>


                    <div class="w-1/2">
                        <label class="block text-ms font-semibold text-au-brown-darkest mb-2">
                            Estado
                        </label>

                        <label class="inline-flex items-center gap-3 cursor-pointer">

                            <div class="relative">
                                <input type="hidden" name="estado" value="0">
                                <input
                                    type="checkbox"
                                    name="estado"
                                    value="1"
                                    class="sr-only peer">

                                <div class="w-11 h-6 bg-au-cream-border rounded-full peer-checked:bg-au-coral transition-all"></div>

                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>


                                <span class="ml-3 text-sm text-au-brown-darkest peer-checked:hidden">
                                    Inactiva
                                </span>
                                <span class="ml-3 text-sm text-au-brown-darkest hidden peer-checked:inline">
                                    Activa
                                </span>
                            </div>
                            
                        </label>
                    </div>
                </div>

                <div class="w-full mb-6">

                    <label class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Imagen 
                    </label>

                    <input 
                        type="file" 
                        id="imagen" 
                        name="imagen" 
                        accept="image/*"
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest focus:outline-none focus:ring-2 focus:ring-au-coral"
                        onchange="previewImage(event)"
                    >

                    <div class="mt-4">
                        <img
                            id="preview"
                            src="#"
                            alt="Vista previa"
                            class="hidden w-40 h-40 object-cover rounded-lg border border-au-cream-border"
                        >
                    </div>

                    <script>
                    function previewImage(event) {
                        const imagen = document.getElementById('preview');

                        imagen.src = URL.createObjectURL(event.target.files[0]);

                        imagen.classList.remove('hidden');
                    }
                </script>

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