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

        <a href="{{ route ('categoria.index') }}"
        class="mb-2 flex items-center gap-3 px-3 py-2.5 rounded-lg capitalize transition-all 
        {{ request()->routeIs('categoria.index')
                            ?
                                ' bg-au-cream-card text-au-coral-text'
                            :  
                                'text-au-cream hover:bg-au-text-muted'}}" >
            <i class="fa-solid fa-tag w-4 text-center"></i>{{-- icono --}}
            <span x-show="sidebarOpen" x-transition>
                Categoria
            </span>
        </a>
    </nav>
</aside>