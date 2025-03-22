<!DOCTYPE html>
<html>
<head>
    <title>QR Code Généré</title>
</head>
<body>
    <h1>QR Code Généré</h1>
    <img src="{{ $qrCodeUrl }}" alt="QR Code">
    <br>
    <a href="{{ $qrCodeUrl }}" download>Télécharger le QR Code</a>
</body>
</html>
