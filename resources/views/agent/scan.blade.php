<!DOCTYPE html>
<html>
<head>
    <title>Scan Agent</title>
</head>
<body>
    <h1>Scanner une référence</h1>
    <form action="{{ route('agent.scan') }}" method="post">
        @csrf
        <input type="text" name="reference" placeholder="Entrer la référence">
        <button type="submit">Générer QR Code</button>
    </form>
</body>
</html>