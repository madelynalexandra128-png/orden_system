<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>
<body class=" bg-au-cream">

    <div x-data="{sidebarOpen: true}"
    class="min-h-screen">

        @include('components.bar')
        <div class="transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-20' ">

            {{-- nav --}}
            @include('components.nav') {{-- para llamar el componente  --}}
            <main class="p-12">
                @yield('content')
            </main>
        </div>
    </div>

    
</body>
</html>