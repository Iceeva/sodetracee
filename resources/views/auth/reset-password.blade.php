<x-guest-layout>
    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token de réinitialisation -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Adresse Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Nouveau Mot de Passe -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation du Mot de Passe -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Bouton de soumission -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Réinitialiser le mot de passe') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
