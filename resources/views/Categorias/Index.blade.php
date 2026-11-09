@extends('layouts.app')
@section('title')
    Categorias
@endsection

@section('content')
<main class="flex-1 p-1 ">
    <h1 class="text-lg sm:text-xl font-semibold text-au-brown-darkest truncate">
            Categorías
        </h1>
    <div class="flex items-center justify-between mb-1 mt-2">
        <p class="text-s text-au-text-muted font-semibold" wire:navigate >categorias activas {{ $contar }} </p>{{-- para contar cuanta scategorias hay activa se va a hacer luego --}} 

        <a href="{{ route('categoria.create') }}"    class=" bg-au-text-muted text-au-cream text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all">
        <i class="fa-solid fa-plus text-[10px]"></i> Nueva categoría </a>
    
    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

            {{ session('success') }}

        </div>

    @endif


    {{-- table --}}
    <div class="dt-container">
        <table class="datatable" id='tablePrins'>
            
            <thead class=" bg-au-cream-card">
                <tr>
                    <th "> N°</th>

                    <th >
                        Categoría
                    </th>

                    <th >
                        Descripcion
                    </th>

                    <th >
                        Productos
                    </th>{{-- cantidad de productoq ue tiene etsa categoria  --}}

                    <th >
                        Estado
                    </th>

                    <th >
                        Acciones
                    </th>

                </tr>
            </thead>

            <tbody>
                
                @foreach ($categorias as $categoria )
                    
                        <td >{{ $loop->iteration }}</td>{{-- nuemero  de vuelta enpieza en uno  --}}
                        <td >{{$categoria->nombre }}</td>
                        <td >{{$categoria->descripcion }}</td>
                        <td >{{ $categoria->contarproducto }}</td>{{-- cantidad de productos en esa categoria --}}
                        <td >
                            <form action="{{ route('categoria.canbiarEstado',$categoria->id)}}" method="POST" wire:navigate>
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
                                                    {{ $categoria->estado ==1 ? 'checked':'' }}>

                                                <div class="w-11 h-6 bg-au-cream-border rounded-full peer-checked:bg-au-coral transition-all"></div>

                                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                                            </div>
                                            @if ($categoria->estado == 1  )
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

                                <a href="{{ route ('categoria.edit',$categoria->id)}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('categoria.destroy',$categoria->id) }}" method="POST">
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