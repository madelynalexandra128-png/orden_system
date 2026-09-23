@extends('layout.app')
@section('title')
        Productos
@endsection

@section('content')

<main class="flex-1 p-1 ">
    <h1 class="text-lg sm:text-xl font-semibold text-au-brown-darkest truncate">
            Poductos
    
    </h1>
    <div class="flex items-center justify-between mb-1 mt-2">
        <p class="text-xs text-au-text-muted">Productos activos </p>{{-- para contar cuanta scategorias hay activa se va a hacer luego --}}

        <a href="{{ route('producto.create') }}"    class=" bg-au-text-muted text-au-cream text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all">
        <i class="fa-solid fa-plus text-[10px]"></i> Nuevo Producto</a>
    
    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

            {{ session('success') }}

        </div>

    @endif

    {{-- Buscador --}}
    <div class="relative mt-4 mb-4 max-w-md">

        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-au-text-muted text-sm"></i>
        <input type="search" placeholder="Buscar producto..."
        class="pl-9 pr-4 py-2 w-80 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-coral">
    </div>

    {{-- table --}}
    <div class=" bg-white rounded-x border border-au-cream-border overflow-hidden">
        <table class=" w-full text-left">
            
            <thead class=" bg-au-cream-card">
                <tr>
                    <th class="w-14 p-3 text-base font-semibold text-au-brown-dark"> N°</th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Nombre
                    </th>

                    <th class="w-24 p-3 text-base font-semibold text-au-brown-dark">
                        Precio
                    </th>

                    <th class="w-28 p-3 text-base font-semibold text-au-brown-dark">
                        Precio Compra
                    </th>

                    <th class="w-20 p-3 w text-base font-semibold text-au-brown-dark">
                        Stock
                    </th>

                    <th class="w-14 p-3 text-base font-semibold text-au-brown-dark"> 
                        Puntos
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Categoria
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Imagen
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Estado
                    </th>


                    <th class=" p-3 text-base font-semibold text-au-brown-dark text-center">
                        Acciones
                    </th>

                </tr>
            </thead>

            <tbody>
                
                @foreach ($productos as $producto )
                    <tr class="{{ $loop->even ? 'bg-au-cream-card': 'bg-white' }} border-t border-au-cream-border"> {{--  EL $LOOP->EVEN  es si en nuemro es par este color si no el siguiente  --}} 
                        <td class="p-3 text-sm text-au-text-muted">{{ $loop->iteration }}</td>{{-- nuemero  de vuelta enpieza en uno  --}}
                        <td class="p-3 text-sm text-au-text-muted">
                            <div class="font-medium text-gray-800">{{ $producto->nombre }}</div>
                            <div class="text-xs text-gray-500 truncate max-width:220px">
                                {{ $producto->descripcion }}
                            </div>
                        </td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $producto->precio }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $producto->precioCompra }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $producto->stock }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $producto->puntos }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $producto->categoria->nombre }}</td>
                        <td class="p-3 text-sm text-au-text-muted">

                            @if($producto->imagen)

                                <img 
                                    src="{{ asset('storage/' . $producto->imagen) }}"
                                    alt="{{ $producto->nombre }}"
                                    class="w-20 h-20 object-cover rounded-lg"
                                >

                            @else

                                <span class="text-au-text-muted">
                                    Sin imagen
                                </span>

                            @endif
                        </td>
                        
                        <td class="p-3 text-sm text-au-text-muted">
                            <form action="" method="POST">
                                @csrf
                                    <div class="flex gap-3 text-au-text-muted">

                                        <label class="inline-flex items-center gap-3 cursor-pointer">

                                            <div class="relative">
                                                <input type="hidden" name="estado" value="0">
                                                <input
                                                    type="checkbox"
                                                    name="estado"
                                                    value="1"
                                                    class="sr-only peer"
                                                    onchange="this.form.submit()"  {{-- canbiar a un botoon --}}
                                                    {{ $producto->estado ==1 ? 'checked':'' }}>

                                                <div class="w-11 h-6 bg-au-cream-border rounded-full peer-checked:bg-au-coral transition-all"></div>

                                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                                            </div>
                                            @if ($producto ->estado == 1)
                                                <span class="bg-green-100 text-green-700 text-[10px] font-medium px-2 py-1 rounded-full">
                                                    Activa
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-500 text-[10px] font-medium px-2 py-1 rounded-full">
                                                    Inactiva
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                            </form>
                        </td>
                        <td class="p-3">

                            <div class="flex justify-center text-au-text-muted items-center gap-2 ">

                                <a href="">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Eliminar">
                                        <i class="fa-regular fa-trash-can text-lg"></i>
                                    </button>
                                
                                </form>

                            </div>
                        </td>
                    </tr>
                    
                @endforeach

            </tbody>  

        </table>

    </div> 

</main>

@endsection