<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú digital</title>

    @vite(['resources/css/app.css'])

    @livewireStyles
</head>

<body class="min-h-screen bg-au-cream">

    <livewire:menu :codigo-qr="$codigoQr" />

    @livewireScripts

</body>
</html>