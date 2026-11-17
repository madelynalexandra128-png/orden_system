@extends('layouts.app')
@section('title')
    Mesa
@endsection

@section('content')


<main class="flex-1 p-1 ">
    <h1 class="text-lg sm:text-xl font-semibold text-au-brown-darkest truncate">
        Mesas
    
    </h1>
    <div class="flex items-center justify-between mb-1 mt-2">
        <p class="text-xs text-au-text-muted"> </p>{{-- para contar cuanta scategorias hay activa se va a hacer luego --}}

        <a href="{{ route('mesa.create') }}"    class=" bg-au-text-muted text-au-cream text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all">
        <i class="fa-solid fa-plus text-[10px]"></i> Nueva Mesa</a>
    
    </div>

    {{-- Notificaciones --}}
    @if(session('success') || session('error'))

        <div id="notificacion"
            class="fixed top-5 right-5 z-50 px-5 py-4 rounded-xl shadow-lg
            flex items-center gap-3 min-width: 300px
            {{ session('success') ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' }}">

            @if(session('success'))
                <i class="fa-solid fa-circle-check text-xl"></i>
                <span>{{ session('success') }}</span>
            @else
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <span>{{ session('error') }}</span>
            @endif

        </div>

        <script>
            setTimeout(() => {
                const notificacion = document.getElementById('notificacion');

                if (notificacion) {
                    notificacion.style.transition = 'opacity 0.5s ease';
                    notificacion.style.opacity = '0';

                    setTimeout(() => notificacion.remove(), 500);
                }
            }, 3000);
        </script>

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

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Capacidad
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Estado
                    </th>

                    <th class="p-3 text-base font-semibold text-au-brown-dark">
                        Codigo QR
                    </th>


                    <th class=" p-3 text-base font-semibold text-au-brown-dark text-center">
                        Acciones
                    </th>

                </tr>
            </thead>

            <tbody>
                
                @foreach ($mesas as $mesa)
                    <tr class="{{ $loop->even ? 'bg-au-cream-card': 'bg-white' }} border-t border-au-cream-border"> {{--  EL $LOOP->EVEN  es si en nuemro es par este color si no el siguiente  --}} 
                        <td class="p-3 text-sm text-au-text-muted">{{ $loop->iteration }}</td>{{-- nuemero  de vuelta enpieza en uno  --}}
                        <td class="p-3 text-sm text-au-text-muted">
                            <div class="font-medium text-gray-800">{{ $mesa->nombre }}</div>
                        </td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $mesa->capacidad }}</td>
                        <td class="p-3 text-sm text-au-text-muted">{{ $mesa->estado }}</td>
                        <td class="p-3">
                            <button
                                type="button"
                                onclick="Livewire.dispatch('abrir-qr', { mesaId: {{ $mesa->id }} })"
                                class="p-1 text-au-text-muted hover:text-au-coral"
                                title="Ver código QR"
                            >
                                <i class="fa-regular fa-eye text-lg"></i>
                            </button>
                        </td>
                        
                        <td class="p-3">

                            <div class="flex justify-center text-au-text-muted items-center gap-2 ">

                                <a href="{{ route('mesa.edit',$mesa->id) }}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('mesa.destroy', $mesa->id) }}" method="POST">
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

@livewire('mesa-qr-modal')

@endsection