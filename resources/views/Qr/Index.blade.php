<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $mesa->nombre }}</title>

    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-au-cream flex items-center justify-center p-5">

    <main class="w-full max-w-md rounded-2xl bg-white p-7 text-center shadow-lg">

        <h1 class="text-2xl font-bold text-au-brown-darkest">
            Bienvenido a {{ $mesa->nombre }}
        </h1>

        <p class="mt-3 text-au-text-muted">
            ¿Deseas iniciar sesión o continuar como invitado?
        </p>

        <div class="mt-7 space-y-3">

            <a
                href="{{ route('cliente.create') }}"
                class="block w-full rounded-lg bg-au-brown-dark px-4 py-3 font-medium text-white hover:opacity-90"
            >
                Iniciar sesión
            </a>

            <a
                href="{{ url('/menu/' . $mesa->codigoQr . '/productos') }}"
                class="block w-full rounded-lg bg-au-coral px-4 py-3 font-medium text-white hover:opacity-90"
            >
                Continuar como invitado
            </a>

        </div>

    </main>

</body>
</html>