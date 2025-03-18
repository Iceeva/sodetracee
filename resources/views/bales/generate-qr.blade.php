@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1>Générer un QR Code</h1>
        <form method="POST" action="{{ route('bales.generate-qr') }}">
            @csrf
            <div>
                <label for="reference">Référence de la balle</label>
                <input type="text" name="reference" id="reference" class="block mt-1 w-full" required>
                @error('reference')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2">Générer</button>
        </form>
    </div>
@endsection