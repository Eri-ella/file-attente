@php
    $estModification = isset($service);
@endphp
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $estModification ? 'Modifier le service' : 'Ajouter un service' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
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

        <form method="POST"
              action="{{ $estModification ? route('manager.connexionmanager.service.update', $service->id) : route('manager.connexionmanager.service.store') }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-5">
            @csrf
            @if($estModification)
                @method('PUT')
            @endif

            {{-- ===== Colonne gauche ===== --}}
            <div class="space-y-5">
                <div>
                    <label for="nom" class="block text-sm text-gray-500 mb-1">Nom du service</label>
                    <input type="text" id="nom" name="nom"
                           value="{{ old('nom', $estModification ? $service->nom : '') }}"
                           class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>

                <div>
                    <label for="description" class="block text-sm text-gray-500 mb-1">Description</label>
                    <textarea id="description" name="description" rows="5" required
                              class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">{{ old('description', $estModification ? $service->description : '') }}</textarea>
                </div>

                {{-- SELECT Catégorie --}}
                <div>
                    <label for="categorie_id" class="block text-sm text-gray-500 mb-1">Catégorie</label>
                    <select id="categorie_id" name="categorie_id" required
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52] bg-white">
                        <option value="">-- Choisir une catégorie --</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                {{ old('categorie_id', $estModification ? $service->categorie_id : '') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SELECT Critère Technique --}}
                <div>
                    <label for="critere_technique" class="block text-sm text-gray-500 mb-1">Critère Technique</label>
                    <select id="critere_technique" name="critere_technique" required onchange="gererCout()"
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52] bg-white">
                        <option value="Gratuit" {{ old('critere_technique', $estModification ? $service->critere_technique : '') === 'Gratuit' ? 'selected' : '' }}>Gratuit</option>
                        <option value="Payant" {{ old('critere_technique', $estModification ? $service->critere_technique : '') === 'Payant' ? 'selected' : '' }}>Payant</option>
                    </select>
                </div>
            </div>

            {{-- ===== Colonne droite ===== --}}
            <div class="space-y-5">
                <div>
                    <label for="duree" class="block text-sm text-gray-500 mb-1">Durée (minutes)</label>
                    <input type="number" id="duree" name="duree" required min="1"
                        value="{{ old('duree', $estModification ? $service->duree : '') }}"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>

                <div>
                    <label for="cout" class="block text-sm text-gray-500 mb-1">Coût (FCFA)</label>
                    <input type="number" id="cout" name="cout" required min="0"
                           value="{{ old('cout', $estModification ? $service->cout : 0) }}"
                           class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>

                {{-- SELECT Profil Usager --}}
                <div>
                    <label for="profil_usager_id" class="block text-sm text-gray-500 mb-1">Profil Usager</label>
                    <select id="profil_usager_id" name="profil_usager_id" required
                            class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52] bg-white">
                        <option value="">-- Choisir un profil --</option>
                        @foreach($profilUsagers as $profil)
                            <option value="{{ $profil->id }}"
                                {{ old('profil_usager_id', $estModification ? $service->profil_usager_id : '') == $profil->id ? 'selected' : '' }}>
                                {{ $profil->nom }}
                            </option>
                        @endforeach
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

    <script>
        function gererCout() {
            const critere = document.getElementById('critere_technique').value;
            const champCout = document.getElementById('cout');
            if (critere === 'Gratuit') {
                champCout.value = 0;
                champCout.readOnly = true;
                champCout.classList.add('bg-gray-100');
            } else {
                champCout.readOnly = false;
                champCout.classList.remove('bg-gray-100');
            }
        }
        // Initialiser au chargement
        gererCout();
    </script>

</body>
</html>