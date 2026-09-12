<aside class="fixed left-0  top-0 z-40 h-screen border-r border-au-cream-border bg-au-text-muted transition-all duration-300" :class="sidebarOpen ? 'w-64' : 'w-20' ">

    {{-- logo --}}
    <div class="flex h-18 items-center gap-3 px-5 border-b border-white/10"> 
        <div class="w-10 h-10 rounded-full  bg-au-cream-card flex items-center justify-center text-au-coral-text text-xs font-semibold">
            <i class="fa-solid fa-utensils"></i>
        </div>

        <span x-show="sidebarOpen" x-transition   class=" text-au-cream ml-3 text-xl font-bold">
            ORDEN SYSTEM
        </span>
    </div>

    <nav class="mt-6 px-3">
        <a href="{{ route('home') }}"
        class="mb-2 flex items-center gap-3 px-3 py-2.5 rounded-lg capitalize transition-all 
        {{ request()->routeIs('home')
                            ?
                                ' bg-au-cream-card text-au-coral-text'
                            :  
                                'text-au-cream hover:bg-au-text-muted'}}">
            <i class="fa-solid fa-grip w-4 text-center"></i>{{-- icono --}}
            <span x-show="sidebarOpen" x-transition>
                Home
            </span>
        </a>

        {{-- categorias --}}

        <a href="{{ route ('categoria.index') }}"
        class="mb-2 flex items-center gap-3 px-3 py-2.5 rounded-lg capitalize transition-all 
        {{ request()->routeIs('categoria.index')
                                ?
                                ' bg-au-cream-card text-au-coral-text'
                            :  
                                'text-au-cream hover:bg-au-text-muted'}}" >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.59 13.41L13.41 20.59a2 2 0 01-2.82 0L3.41 13.41A2 2 0 013 12V5a2 2 0 012-2h7a2 2 0 011.41.59l7.18 7.18a2 2 0 010 2.82z"/>
                <circle cx="7.5" cy="7.5" r="1" fill="currentColor"/>
            </svg>{{-- icono --}}

            <span x-show="sidebarOpen" x-transition>
                Categoria
            </span>
        </a>


        {{-- productos --}}
        
        <a href="{{ route('producto.index') }}"
            class="mb-2 flex items-center gap-3 px-3 py-2.5 rounded-lg capitalize transition-all 
                {{ request()->routeIs('producto.index') 
                            ?
                                ' bg-au-cream-card text-au-coral-text'
                            :  
                                'text-au-cream hover:bg-au-text-muted'}}">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5L12 3l8 4.5v9L12 21l-8-4.5v-9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5l8 4.5 8-4.5"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 5l8 4.5"/>
            </svg>

            <span x-show="sidebarOpen" x-transition>
                Producto
            </span>
                    

        </a>
    </nav>
</aside>