@extends('layouts.app')
@section('title')
        Productos
@endsection

@section('content')
    @php
        $mostrarModalStock = false;
    @endphp

<main class="flex-1 p-1 ">
    <h1 class="text-lg sm:text-xl font-semibold text-au-brown-darkest truncate">
            Poductos
    
    </h1>
    <div class="flex items-center justify-between mb-1 mt-2">
        <p class="text-s text-au-text-muted font-semibold" wire:navigate >Productos activos {{ $contar }} </p> 

        <a href="{{ route('producto.create') }}"    class=" bg-au-text-muted text-au-cream text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all">
        <i class="fa-solid fa-plus text-[10px]"></i> Nuevo Producto</a>
    
    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

            {{ session('success') }}

        </div>

    @endif



    {{-- table --}}
    <div class="dt-container">
        <table class=" datatable" id='tablePrins'>
            
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
                    <tr class=" border-t border-au-cream-border"> {{--  EL $LOOP->EVEN  es si en nuemro es par este color si no el siguiente  --}} 
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
                            <form action="{{ route('producto.canbiarEstadoProducto',$producto->id) }}" method="POST">
                                @csrf
                                    <div class="flex gap-3 text-au-text-muted">

                                        <label class="inline-flex items-center gap-3 cursor-pointer">

                                            
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

                            <div class="flex justify-center items-center gap-3 text-au-text-muted">

                            {{-- Añadir stock --}}
                            <button
                                type="button"
                                onclick="document.getElementById('modalStock-{{ $producto->id }}').showModal()"
                                title="Añadir stock"
                                class="text-green-600 hover:text-green-800"
                            >
                                <i class="fa-solid fa-boxes-stacked text-lg"></i>
                            </button>

                            {{-- Editar --}}
                            <a href="{{ route('producto.edit', $producto->id) }}"
                            title="Editar">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('producto.destroy', $producto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 p-1"
                                        title="Eliminar">
                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                </button>
                            </form>

                        </div>

                        {{-- Modal para añadir stock --}}
                        <dialog
                            id="modalStock-{{ $producto->id }}"
                            class="m-auto w-full max-w-md rounded-xl p-0 backdrop:bg-black/50"
                        >
                            <div class="bg-white p-6">

                                <div class="flex items-center justify-between mb-5">
                                    <h2 class="text-lg font-bold text-au-brown-darkest">
                                        Añadir stock
                                    </h2>

                                    <button
                                        type="button"
                                        onclick="document.getElementById('modalStock-{{ $producto->id }}').close()"
                                        class="text-au-text-muted hover:text-red-600 text-xl"
                                    >
                                        &times;
                                    </button>
                                </div>

                                <form action="{{ route('producto.agregarStock', $producto->id) }}"
                                    method="POST">

                                    @csrf

                                    <div class="space-y-4">

                                        <div>
                                            <label class="block text-sm font-semibold text-au-brown-dark">
                                                Producto
                                            </label>

                                            <p class="mt-1 text-au-text-muted">
                                                {{ $producto->nombre }}
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-au-brown-dark">
                                                Stock actual
                                            </label>

                                            <p class="mt-1 text-au-text-muted">
                                                {{ $producto->stock }} unidades
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-au-brown-dark">
                                                Cantidad que deseas añadir
                                            </label>

                                            <input
                                                type="number"
                                                name="cantidad"
                                                min="1"
                                                step="1"
                                                required
                                                class="mt-2 w-full rounded-lg border border-au-cream-border px-4 py-3 outline-none focus:border-au-coral"
                                                placeholder="Ingresa la cantidad"
                                            >
                                        </div>

                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">

                                        <button
                                            type="button"
                                            onclick="document.getElementById('modalStock-{{ $producto->id }}').close()"
                                            class="rounded-lg border border-au-cream-border px-4 py-2 text-au-brown-dark"
                                        >
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-au-text-muted px-5 py-2 font-semibold text-au-cream hover:opacity-90"
                                        >
                                            Añadir stock
                                        </button>

                                    </div>

                                </form>

                            </div>
                        </dialog>
                        </td>
                    </tr>
                    
                @endforeach

            </tbody>  

        </table>

    </div> 

</main>

@endsection