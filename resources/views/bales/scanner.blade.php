<!DOCTYPE html>
<html>
<head>
    <title>Scanner une référence</title>
</head>
<body>
    <h1>Scanner une référence</h1>
    <form action="{{ route('scanner.generate') }}" method="post">
        @csrf
        <input type="text" name="reference" placeholder="Entrer la référence" required>
        <button type="submit">Générer QR Code</button>
    </form>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
