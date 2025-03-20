@extends('layouts.guest')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('status'))
            <p style="color: green;" class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </p>
        @endif

        <!-- Tabs Navigation -->
        <div class="flex items-center justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SODECO" class="w-5 h-5 mr-2">
            <div class="flex justify-center">
                <button id="loginTab" class="px-4 py-2 text-blue-600 border-b-2 border-blue-600">Connexion</button>
                <button id="registerTab" class="px-4 py-2 text-gray-600">Inscription</button>
            </div>
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" /> <!-- Corrigé "mot de passe" dans l’ID -->
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Vous avez oublié votre mot de passe ?') }}
                    </a>
                @endif
                <x-primary-button class="ms-3">{{ __('Se connecter') }}</x-primary-button>
            </div>
        </form>

        <!-- Register Form -->
        <form id="registerForm" method="POST" action="{{ route('register') }}" class="hidden">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>
            <div class="flex items-center justify-between mt-4">
                <x-primary-button class="ms-3">{{ __('S\'inscrire') }}</x-primary-button>
            </div>
        </form>

        <script>
            document.getElementById('loginTab').addEventListener('click', function () {
                document.getElementById('loginForm').classList.remove('hidden');
                document.getElementById('registerForm').classList.add('hidden');
                this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                document.getElementById('registerTab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            });
            document.getElementById('registerTab').addEventListener('click', function () {
                document.getElementById('registerForm').classList.remove('hidden');
                document.getElementById('loginForm').classList.add('hidden');
                this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                document.getElementById('loginTab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            });
        </script>
    </div>
@endsection