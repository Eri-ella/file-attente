<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Liste des clients</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto">
        <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des clients</h1>

        <table class="w-full text-left text-sm bg-[#FDFFFF]">
            <thead class="border border-[#222D52]/50">
                <tr class="text-[#222D52]/70 border border-[#222D52]/50">
                    <th class="pb-2 font-normal">Nom</th>
                    <th class="pb-2 font-normal">Prénom</th>
                    <th class="pb-2 font-normal">Adresse e-mail</th>
                    <th class="pb-2 font-normal">Téléphone</th>
                    <th class="pb-2 font-normal">Âge</th>
                    <th class="pb-2 font-normal">Sexe</th>
                    <th class="pb-2 font-normal">Statut</th>
                    <th class="pb-2 font-normal"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr class="border border-[#222D52]/50">
                        <td class="py-4 text-gray-800">{{ $client->nom }}</td>
                        <td class="py-4 text-gray-800">{{ $client->prenom }}</td>
                        <td class="py-4 text-gray-800">{{ $client->email }}</td>
                        <td class="py-4 text-gray-800">{{ $client->numero }}</td>
                        <td class="py-4 text-gray-800">{{ $client->age }}</td>
                        <td class="py-4 text-gray-800">{{ $client->sexe }}</td>
                        <td class="py-4 text-gray-800 statut">{{ $client->statut ?? 'actif' }}</td>
                        <td class="py-4">
                            <button 
                                onclick="basculerStatut(this, {{ $client->id }})" 
                                class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50"
                            >
                                {{ ($client->statut ?? 'actif') === 'actif' ? 'Suspendre' : 'Activer' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500">
                            Aucun client trouvé dans la base de données.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>

    <script>
        function basculerStatut(bouton, clientId) {
            const ligne = bouton.closest('tr');
            const celluleStatut = ligne.querySelector('.statut');
            const texteActuel = celluleStatut.textContent.trim();

            bouton.disabled = true;
            bouton.textContent = 'Chargement...';

            fetch(`/admin/superclient/${clientId}/basculer-statut`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    celluleStatut.textContent = data.nouveau_statut;
                    bouton.textContent = data.nouveau_statut === 'actif' ? 'Suspendre' : 'Activer';
                }
            })
            .catch(error => console.error('Erreur :', error))
            .finally(() => { bouton.disabled = false; });
        }
    </script>
</body>
</html>