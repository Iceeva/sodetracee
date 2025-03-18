<!DOCTYPE html>
<html>
<head>
    <title>QR Code - {{ $reference }}</title>
</head>
<body>
    <h1>QR Code pour la balle {{ $reference }}</h1>
    <img src="{{ $qrCodePath }}" alt="QR Code">
</body>
</html>