@extends('layout.app')
@section('title')
    Editar categoria
@endsection

@section('content')

    {{-- Breadcrumb --}}   
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('categoria.index') }}" class="hover:text-au-brown-dark">Categorías</a>
        <span class="mx-1">/</span>
        <span class="text-au-brown-darkest">editar categoría</span>{{-- eesto es como que diga categoria/nueva categoria ubicandoo donde estamso  --}}
    </div>

    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">Crear categoría</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-xl bg-white rounded-x1 border-b-au-brown-dark p-8">
            
            <form action ="{{ route('categoria.update',$categorias->id) }} "method='POST'>
                @csrf
                @method('PUT')

                <div class="mb-6">

                    <label for ="nombre" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Nombre de la categoría
                    </label>

                    <input 
                        type="text" {{-- que tipo de datos escribe  --}}
                        id="nombre" {{-- identificar el canpoe en html --}}
                        name="nombre" {{-- nombre del dato que recibe laravel --}}
                        value="{{$categorias->nombre}}"
                        placeholder="Ej: Bebidas Frias"{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
                </div>


                {{-- descripcion  --}}
                <div class="mb-6">

                    <label for ="Descripcion" class="block text-ms font-semibold text-au-brown-darkest mb-2">
                        Descripcion
                    </label>

                    <input
                        type="text"
                        id="descripcion" {{-- identificar el canpoe en html --}}
                        name="descripcion"
                        rows="3" {{-- nombre del dato que recibe laravel --}}
                        value="{{$categorias->descripcion}}"
                        placeholder="Ej: Espresso, latte, capuchino"{{--  ejemplo de que escribir  --}}
                        class="w-full px-4 py-2.5 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral"
                        ></input>
                </div>


                <div class="mb-6">
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
                                class="sr-only peer"
                                {{ $categorias->estado == 1 ? 'checked' : '' }}
                                >

                            <div class="w-11 h-6 bg-au-cream-border rounded-full peer-checked:bg-au-coral transition-all"></div>

                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>

                            <span class="ml-3 text-sm text-au-brown-darkest peer-checked:hidden" >
                                Inactiva
                            </span>
                            <span class="ml-3 text-sm text-au-brown-darkest hidden peer-checked:inline">
                                Activa
                            </span>
                        </div>
                    </label>
                </div>

                <hr class="border-au-cream-border mb-6">

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('categoria.index') }}"
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