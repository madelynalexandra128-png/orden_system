@extends('layout.app')
@section('title')
    Categorias
@endsection

@section('content')
<main class="flex-1 p-1 ">
    <h1 class="text-lg sm:text-xl font-semibold text-au-brown-darkest truncate">
            Categorías
        </h1>
    <div class="flex items-center justify-between mb-1 mt-2">
        <p class="text-xs text-au-text-muted">categorias activas </p>{{-- para contar cuanta scategorias hay activa se va a hacer luego --}}

        <a href="{{ route('categoria.create') }}"    class=" bg-au-text-muted text-au-cream text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all">
        <i class="fa-solid fa-plus text-[10px]"></i> Nueva categoría </a>
    
    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

            {{ session('success') }}

        </div>

    @endif

    {{-- Buscador --}}
    <div class="relative mt-4 mb-4 max-w-md">

        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-au-text-muted text-sm"></i>
        <input type="search" placeholder="Buscar categoría..."
        class="pl-9 pr-4 py-2 w-80 rounded-lg bg-white border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-coral">
    </div>

    {{-- table --}}
    <div class=" bg-white rounded-x border border-au-cream-border overflow-hidden">
        <table class=" w-full text-left">
            
            <thead class=" bg-au-cream-card">
                <tr>
                    <th class="w-14 p-3 text-base font-semibold text-au-brown-dark"> N°</th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Categoría
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Descripcion
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Productos
                    </th>{{-- cantidad de productoq ue tiene etsa categoria  --}}

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Estado
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Acciones
                    </th>

                </tr>
            </thead>

            <tbody>
                
                @foreach ($categorias as $categoria )
                    <tr class="{{ $loop->even ? 'bg-au-cream-card': 'bg-white' }} border-t border-au-cream-border"> {{--  EL $LOOP->EVEN  es si en nuemro es par este color si no el siguiente  --}} 
                        <td class="p-3 text-sm text-au-text-muted">{{ $loop->iteration }}</td>{{-- nuemero  de vuelta enpieza en uno  --}}
                        <td class="p-3 text-sm text-au-text-muted">{{$categoria->nombre }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{$categoria->descripcion }}</td>
                        <td class="p-3 text-sm text-au-text-muted"></td>{{-- cantidad de productos en esa categoria --}}
                        <td class="p-3 text-sm text-au-text-muted">
                            @if ($categoria->estado == 1 )
                                <span class="bg-green-100 text-green-700 text-[10px] font-medium px-2 py-1 rounded-full">
                                    Activa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-500 text-[10px] font-medium px-2 py-1 rounded-full">
                                    Inactiva
                                </span>
                            @endif  
                        </td>
                        <td></td>
                    </tr>
                    
                @endforeach

            </tbody>

        </table>

    </div> 

</main>




@endsection