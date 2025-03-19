@extends('layouts.guest')

@section('content')
    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Mot de passe oublié ? Pas de souci. Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.') }}
        </div>

        <!-- Message de statut -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Erreurs de validation -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Adresse Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Bouton d'envoi -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Envoyer le lien de réinitialisation') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
