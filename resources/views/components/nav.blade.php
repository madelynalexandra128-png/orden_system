<header class="sticky top-0 z-30 flex h-18 items-center justify-between bg-au-cream border-b border-au-cream-border  px-6 backdrop-blur">
    


    <div class="flex items-center gap-4">

        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="flex h-10 w-10 items-center justify-center rounded-lg border-au-cream-border text-au-cream bg-au-text-muted hover:text-au-brown-dark cursor-pointer transition-all">
            <i class="fa-solid fa-bars"></i>
        </button>

        <span class="font-script font-bold text-2xl text-au-brown-dark" >
            @yield('title')
        </span>

    </div>

    

    <div class="flex items-center gap-4 "> {{-- agregar elementos  --}}

        {{-- barra de búsqueda --}}
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-au-text-muted"></i>
            <input type="search" placeholder="Buscar"
            class="pl-9 pr-4 py-2 w-56 rounded-lg bg-au-cream border border-au-cream-border text-sm text-au-brown-darkest placeholder-au-text-muted focus:outline-none focus:ring-2 focus:ring-au-coral">
        </div>

        {{-- campana --}}
        <button class="relative">
            <i class="fa-regular fa-bell text-au-text-muted text-lg"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-au-coral rounded-full"></span>
        </button>

        {{-- administrador --}}
        <div class="flex items-center gap-2"> 
        <div class="w-8 h-8 rounded-full bg-au-cream-card flex items-center justify-center text-au-brown-dark text-xs font-semibold">
            AD
        </div>

        <span class=" text-base text-au-brown-darkest">
            Administrador
        </span>

        <i class="fa-solid fa-chevron-down text-xs text-au-text-muted"></i>

    </div>

    </div>

</header>