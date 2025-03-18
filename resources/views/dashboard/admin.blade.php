@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-6">Administration</h1>

        <!-- Boutons de sélection -->
        <div class="mb-6">
            <button onclick="showSection('bales')" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Gérer les balles</button>
            <button onclick="showSection('agents')" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Gérer les agents</button>
            <button onclick="showSection('buyers')" class="bg-blue-500 text-white px-4 py-2 rounded-md">Gérer les acheteurs</button>
        </div>

        <!-- Section Gestion des balles (cachée par défaut) -->
        <section id="bales-section" class="mb-12 hidden">
            <h2 class="text-xl font-semibold mb-4">Gestion des balles</h2>

            <!-- Formulaire Ajouter une balle -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-medium mb-4">Ajouter une balle</h3>
                <form method="POST" action="{{ route('admin.bales.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="reference" class="block text-sm font-medium">Référence</label>
                        <input type="text" name="reference" id="reference" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('reference')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="quality" class="block text-sm font-medium">Qualité</label>
                        <input type="text" name="quality" id="quality" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('quality')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="weight" class="block text-sm font-medium">Poids (kg)</label>
                        <input type="number" step="0.01" name="weight" id="weight" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('weight')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="private_data" class="block text-sm font-medium">Données privées</label>
                        <textarea name="private_data" id="private_data" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
                        @error('private_data')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter</button>
                </form>
            </div>

            <!-- Liste des balles -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium mb-4">Liste des balles</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Référence</th>
                            <th class="px-6 py-3 text-left">Qualité</th>
                            <th class="px-6 py-3 text-left">Poids</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($bales as $bale)
                            <tr>
                                <td class="px-6 py-4">{{ $bale->reference }}</td>
                                <td class="px-6 py-4">{{ $bale->quality }}</td>
                                <td class="px-6 py-4">{{ $bale->weight }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="document.getElementById('edit-bale-{{ $bale->id }}').classList.remove('hidden')" class="text-blue-600">Modifier</button>
                                    <form action="{{ route('admin.bales.destroy', $bale->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Voulez-vous vraiment supprimer cette balle ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-bale-{{ $bale->id }}" class="hidden">
                                <td colspan="4" class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.bales.update', $bale->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="reference-{{ $bale->id }}" class="block text-sm font-medium">Référence</label>
                                            <input type="text" name="reference" id="reference-{{ $bale->id }}" value="{{ $bale->reference }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="quality-{{ $bale->id }}" class="block text-sm font-medium">Qualité</label>
                                            <input type="text" name="quality" id="quality-{{ $bale->id }}" value="{{ $bale->quality }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="weight-{{ $bale->id }}" class="block text-sm font-medium">Poids (kg)</label>
                                            <input type="number" step="0.01" name="weight" id="weight-{{ $bale->id }}" value="{{ $bale->weight }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="private_data-{{ $bale->id }}" class="block text-sm font-medium">Données privées</label>
                                            <textarea name="private_data" id="private_data-{{ $bale->id }}" class="mt-1 block w-full border-gray-300 rounded-md">{{ $bale->private_data }}</textarea>
                                        </div>
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Mettre à jour</button>
                                        <button type="button" onclick="document.getElementById('edit-bale-{{ $bale->id }}').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Annuler</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section Gestion des agents (cachée par défaut) -->
        <section id="agents-section" class="mb-12 hidden">
            <h2 class="text-xl font-semibold mb-4">Gestion des agents</h2>

            <!-- Formulaire Ajouter un agent -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-medium mb-4">Ajouter un agent</h3>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <input type="hidden" name="role" value="agent">
                    <div class="mb-4">
                        <label for="name-agent" class="block text-sm font-medium">Nom</label>
                        <input type="text" name="name" id="name-agent" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email-agent" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email-agent" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password-agent" class="block text-sm font-medium">Mot de passe</label>
                        <input type="password" name="password" id="password-agent" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter</button>
                </form>
            </div>

            <!-- Liste des agents -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium mb-4">Liste des agents</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($agents as $agent)
                            <tr>
                                <td class="px-6 py-4">{{ $agent->name }}</td>
                                <td class="px-6 py-4">{{ $agent->email }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="document.getElementById('edit-agent-{{ $agent->id }}').classList.remove('hidden')" class="text-blue-600">Modifier</button>
                                    <form action="{{ route('admin.users.destroy', $agent->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Voulez-vous vraiment supprimer cet agent ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-agent-{{ $agent->id }}" class="hidden">
                                <td colspan="3" class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update', $agent->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="agent">
                                        <div class="mb-4">
                                            <label for="name-agent-{{ $agent->id }}" class="block text-sm font-medium">Nom</label>
                                            <input type="text" name="name" id="name-agent-{{ $agent->id }}" value="{{ $agent->name }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email-agent-{{ $agent->id }}" class="block text-sm font-medium">Email</label>
                                            <input type="email" name="email" id="email-agent-{{ $agent->id }}" value="{{ $agent->email }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Mettre à jour</button>
                                        <button type="button" onclick="document.getElementById('edit-agent-{{ $agent->id }}').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Annuler</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section Gestion des acheteurs (cachée par défaut) -->
        <section id="buyers-section" class="mb-12 hidden">
            <h2 class="text-xl font-semibold mb-4">Gestion des acheteurs</h2>

            <!-- Formulaire Ajouter un acheteur -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-medium mb-4">Ajouter un acheteur</h3>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <input type="hidden" name="role" value="buyer">
                    <div class="mb-4">
                        <label for="name-buyer" class="block text-sm font-medium">Nom</label>
                        <input type="text" name="name" id="name-buyer" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email-buyer" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email-buyer" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password-buyer" class="block text-sm font-medium">Mot de passe</label>
                        <input type="password" name="password" id="password-buyer" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter</button>
                </form>
            </div>

            <!-- Liste des acheteurs -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium mb-4">Liste des acheteurs</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($buyers as $buyer)
                            <tr>
                                <td class="px-6 py-4">{{ $buyer->name }}</td>
                                <td class="px-6 py-4">{{ $buyer->email }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="document.getElementById('edit-buyer-{{ $buyer->id }}').classList.remove('hidden')" class="text-blue-600">Modifier</button>
                                    <form action="{{ route('admin.users.destroy', $buyer->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Voulez-vous vraiment supprimer cet acheteur ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-buyer-{{ $buyer->id }}" class="hidden">
                                <td colspan="3" class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update', $buyer->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="buyer">
                                        <div class="mb-4">
                                            <label for="name-buyer-{{ $buyer->id }}" class="block text-sm font-medium">Nom</label>
                                            <input type="text" name="name" id="name-buyer-{{ $buyer->id }}" value="{{ $buyer->name }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email-buyer-{{ $buyer->id }}" class="block text-sm font-medium">Email</label>
                                            <input type="email" name="email" id="email-buyer-{{ $buyer->id }}" value="{{ $buyer->email }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                        </div>
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Mettre à jour</button>
                                        <button type="button" onclick="document.getElementById('edit-buyer-{{ $buyer->id }}').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Annuler</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Script JavaScript pour basculer les sections -->
    <script>
        function showSection(section) {
            // Cacher toutes les sections
            document.getElementById('bales-section').classList.add('hidden');
            document.getElementById('agents-section').classList.add('hidden');
            document.getElementById('buyers-section').classList.add('hidden');

            // Afficher la section sélectionnée
            document.getElementById(section + '-section').classList.remove('hidden');
        }
    </script>
@endsection