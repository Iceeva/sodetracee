@extends('layouts.app.navigation')
<x-guest-layout>
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if (session('status'))
            <p style="color: green;" class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </p>
        @endif

        <!-- Tabs Navigation -->
        <div class="flex justify-center mb-4">
            <button id="loginTab" class="px-4 py-2 text-blue-600 border-b-2 border-blue-600">Connexion</button>
            <button id="registerTab" class="px-4 py-2 text-gray-600">Inscription</button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}" class="">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-primary-button class="ms-3">{{ __('Log in') }}</x-primary-button>
            </div>
        </form>

        <!-- Register Form -->
        <form id="registerForm" method="POST" action="{{ route('register') }}" class="hidden">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>
            <div class="flex items-center justify-between mt-4">
                <x-primary-button class="ms-3">{{ __('Register') }}</x-primary-button>
            </div>
        </form>
    </div>

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
</x-guest-layout>
