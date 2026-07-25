@php
    // Si "nom" est fourni dans l'URL, on vient d'un clic sur "Modifier" → champs pré-remplis
    // Sinon, on vient de "+ Ajouter un service" → tout est vide
    $estModification = request()->has('nom');
 
    $nom = request('nom', '');
    $description = request('description', '');
    $categorie = request('categorie', '');
    $duree = request('duree', '');
    $cout = request('cout', '');
    $statut = request('statut', 'actif');
    $profil = request('profil', 'tout public');
@endphp
<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $estModification ? 'Modifier le service' : 'Ajouter un service' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* Retire les flèches +/- des champs number (Chrome, Safari, Edge) */
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            /* Retire les flèches des champs number (Firefox) */
            input[type="number"] {
                -moz-appearance: textfield;
            }
        </style>
    </head>
    <body class="h-full bg-[#F9F8F5]">
    
        <main class="p-10">
        
            <div class="flex items-center gap-3 mb-6">
                <button onclick="history.back()"
                        class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-4 py-2 rounded">
                    Retour
                </button>
            </div>
        
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">
                {{ $estModification ? 'Modifier le service' : 'Ajouter un service' }}
            </h1>
        
            <form method="POST" action="#" class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-5">
                @csrf
        
                {{-- ===== Colonne gauche ===== --}}
                <div class="space-y-5">
                    <div>
                        <label for="nom_service" class="block text-sm text-gray-500 mb-1">Nom du service</label>
                        <input type="text" id="nom_service" name="nom_service" value="{{ $nom }}"
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                    </div>
        
                    <div>
                        <label for="description" class="block text-sm text-gray-500 mb-1">Description</label>
                        <textarea id="description" name="description" rows="7"
                                class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">{{ $description }}</textarea>
                    </div>
        
                    <div>
                        <label for="categorie" class="block text-sm text-gray-500 mb-1">Categorie</label>
                        <input type="text" id="categorie" name="categorie" value="{{ $categorie }}"
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                    </div>
                </div>
        
                {{-- ===== Colonne droite ===== --}}
                <div class="space-y-5">
                    <div>
                        <label for="duree" class="block text-sm text-gray-500 mb-1">Durée Moyenne</label>
                        <input type="number" id="duree" name="duree" value="{{ $duree }}"
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                    </div>
        
                    <div>
                        <label for="cout" class="block text-sm text-gray-500 mb-1">Coût</label>
                        <input type="number" id="cout" name="cout" value="{{ $cout }}"
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                    </div>
        
                    <div>
                        <label for="statut" class="block text-sm text-gray-500 mb-1">Statut</label>
                        <select id="statut" name="statut"
                                class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                            <option value="actif" {{ $statut === 'actif' ? 'selected' : '' }}>actif</option>
                            <option value="inactif" {{ $statut === 'inactif' ? 'selected' : '' }}>inactif</option>
                        </select>
                    </div>
        
                    <div>
                        <label for="profil" class="block text-sm text-gray-500 mb-1">Profil Usager</label>
                        <select id="profil" name="profil"
                                class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                            <option value="tout public" {{ $profil === 'tout public' ? 'selected' : '' }}>tout public</option>
                            <option value="résidents uniquement" {{ $profil === 'résidents uniquement' ? 'selected' : '' }}>résidents uniquement</option>
                        </select>
                    </div>
                </div>
        
                {{-- ===== Bouton ===== --}}
                <div class="md:col-span-2 text-center pt-4">
                    <button type="submit"
                            class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-8 py-2.5 rounded">
                        {{ $estModification ? '+ Enregistrer les modifications' : '+ Ajouter le service' }}
                    </button>
                </div>
        
            </form>
        
        </main>
    
    </body>
</html>