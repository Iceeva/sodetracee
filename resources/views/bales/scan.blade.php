@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1>Informations de la balle</h1>
        <p>Référence : {{ $bale['reference'] }}</p>
        <p>Qualité : {{ $bale['quality'] }}</p>
        <p>Poids : {{ $bale['weight'] }}</p>
    </div>
@endsection