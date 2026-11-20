<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 70px;
        }

        h1 {
            margin-bottom: 5px;
        }

        p {
            color: #555;
        }

        .qr {
            width: 300px;
            height: 300px;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <h1>{{ $mesa->nombre }}</h1>

    <p>Capacidad: {{ $mesa->capacidad }} personas</p>

    <p>Escanea este código para ver el menú.</p>

    <img
        class="qr"
        src="data:image/svg+xml;base64,{{ base64_encode($qrSvg) }}"
        alt="Código QR de {{ $mesa->nombre }}"
    >
</body>
</html>