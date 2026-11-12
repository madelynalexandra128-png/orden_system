
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Orden System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-au-cream">

    <div class="flex min-h-screen items-center justify-center p-4">

        <div class="w-full max-w-md rounded-2xl border border-au-cream-border bg-white p-8 shadow-lg">

            <div class="mb-8 text-center">

                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-au-brown-dark">
                    <span class="text-3xl font-bold text-white">O</span>
                </div>

                <h1 class="text-2xl font-bold text-au-brown-darkest">
                    Orden System
                </h1>

                <p class="mt-2 text-sm text-au-text-muted">
                    Ingresa tu cédula para continuar
                </p>

            </div>

            <form action="{{ route('cliente.login.procesar', $codigoQr) }}"
                method="POST"
                class="space-y-5">

                @csrf

                <div>
                    <label for="cedula"
                        class="mb-2 block text-sm font-semibold text-au-brown-darkest">
                        Número de cédula
                    </label>

                    <input
                        type="text"
                        id="cedula"
                        name="cedula"
                        value="{{ old('cedula') }}"
                        placeholder="Ingresa tu número de cédula"
                        required
                        autofocus
                        class="w-full rounded-lg border border-au-cream-border px-4 py-3 text-sm outline-none transition focus:border-au-coral focus:ring-2 focus:ring-au-coral/20"
                    >

                    @error('cedula')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-au-brown-dark px-4 py-3 font-semibold text-white transition hover:bg-au-brown-darkest">
                    Iniciar sesión
                </button>

            </form>

            <a href="{{ route('menu.inicio', $codigoQr) }}"
               class="mt-5 block text-center text-sm font-medium text-au-text-muted hover:text-au-brown-dark">
                Volver al menú
            </a>

            <p class="mt-8 text-center text-xs text-au-text-muted">
                Orden System · Café Bar
            </p>

        </div>

    </div>

</body>
</html>
