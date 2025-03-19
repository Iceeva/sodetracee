@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
        <p>Bienvenue sur votre tableau de bord, {{ auth()->user()->name }} !</p>
    </div>
@endsection
