@php
    // Récupération des noms de catégories uniques pour le filtre
    $categoriesUniques = $services->pluck('categorie.nom')->unique()->filter()->values();
@endphp

<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-[#F9F8F5]">

    <main class="p-10">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-medium text-[#222D52]">Services</h1>
            <a href="{{ route('manager.connexionmanager.modifierservice') }}" target="tableau"
                class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-4 py-2.5 rounded">
                + Ajouter un service
            </a>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative w-80">
                <input
                    type="text"
                    id="champ-recherche"
                    oninput="filtrerServices()"
                    placeholder="rechercher un service"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 pr-9 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                >
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </div>

            <select id="filtre-categorie" onchange="filtrerServices()"
                    class="border border-[#222D52]/30 rounded px-3 py-2 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                <option value="">Toutes les catégories</option>
                @foreach ($categoriesUniques as $categorieNom)
                    <option value="{{ $categorieNom }}" class="text-gray-800">{{ $categorieNom }}</option>
                @endforeach
            </select>
        </div>

        <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF]">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-500 border-b border-[#222D52]/20">
                        <th class="pb-2 font-normal">Service</th>
                        <th class="pb-2 font-normal">Catégorie</th>
                        <th class="pb-2 font-normal">Durée Moyenne</th>
                        <th class="pb-2 font-normal">Coût (FCFA)</th>
                        <th class="pb-2 font-normal">Profil usager</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody id="corps-services">
                    @foreach ($services as $service)
                        <tr class="border-b border-[#222D52]/10 ligne-service"
                            data-nom="{{ strtolower($service->nom) }}"
                            data-categorie="{{ $service->categorie->nom ?? 'Non catégorisé' }}">
                            <td class="py-3 text-gray-800">{{ $service->nom }}</td>
                            <td class="py-3 text-gray-800">{{ $service->categorie->nom ?? 'Non catégorisé' }}</td>
                            <td class="py-3 text-gray-800">
                                {{ $service->duree ?? '--' }}
                            </td>
                            <td class="py-3 text-gray-800">
                                @if (is_numeric($service->cout))
                                    {{ $service->cout == 0 ? 'Gratuit' : number_format($service->cout, 0, ',', ' ') . ' FCFA' }}
                                @else
                                    {{ $service->cout ?? '--' }}
                                @endif
                            </td>
                            <td class="py-3 text-gray-800">{{ $service->profil_usager->nom ?? 'Non défini' }}</td>
                            <td class="py-3">
                                <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded">
                                    {{ $service->statut ?? 'actif' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('manager.connexionmanager.modifierservice', [
                                        'id' => $service->id,
                                        'nom' => $service->nom,
                                        'description' => $service->description,
                                        'categorie' => $service->categorie->nom ?? '',
                                        'duree' => $service->duree,
                                        'cout' => $service->cout,
                                        'statut' => $service->statut ?? 'actif',
                                        'profil' => $service->profil_usager->nom ?? '',
                                    ]) }}"
                                    target="tableau"
                                    class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50 inline-block">
                                        Modifier
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

    <script>
        function filtrerServices() {
            const texteRecherche = document.getElementById('champ-recherche').value.trim().toLowerCase();
            const categorieChoisie = document.getElementById('filtre-categorie').value;

            document.querySelectorAll('.ligne-service').forEach(function (ligne) {
                const correspondNom = ligne.dataset.nom.includes(texteRecherche);
                const correspondCategorie = categorieChoisie === '' || ligne.dataset.categorie === categorieChoisie;
                ligne.classList.toggle('hidden', !(correspondNom && correspondCategorie));
            });
        }
    </script>

</body>
</html>