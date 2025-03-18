<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    SODECO - Balles
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Accueil</a>
                @auth
                    <a href="{{ route('bales.scan', 'example-reference') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Scanner</a>
                    @if(auth()->user()->role === 'agent')
                        <a href="{{ route('bales.generate-qr') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Générer QR</a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('bales.scan', 'example-reference') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Scanner</a>
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-500">Se connecter</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
