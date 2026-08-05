@extends('layouts.admin')
@section('content')
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des Managers</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class="border border-[#222D52]/50">
                    <tr class="text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal">Nom</th>
                        <th class="pb-2 font-normal">Identifiant</th>
                        <th class="pb-2 font-normal">Téléphone</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($managers as $manager)
                        <tr class="border border-[#222D52]/50">
                            <td class="py-4 text-gray-800">{{ $manager->nom }} {{ $manager->prenom }}</td>
                            <td class="py-4 text-gray-800">{{ $manager->email }}</td>
                            <td class="py-4 text-gray-800">{{ $manager->numero }}</td>
                            <td class="py-4 text-gray-800 statut">{{ $manager->statut ?? 'actif' }}</td>
                            <td class="py-4">
                                <button 
                                    onclick="basculerStatut(this, {{ $manager->id }})" 
                                    class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50"
                                >
                                    {{ ($manager->statut ?? 'actif') === 'actif' ? 'Suspendre' : 'Activer' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                Aucun manager trouvé dans la base de données.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </main>

        <script>
            function basculerStatut(bouton, managerId) {
                const ligne = bouton.closest('tr');
                const celluleStatut = ligne.querySelector('.statut');
                const texteActuel = celluleStatut.textContent.trim();

                bouton.disabled = true;
                bouton.textContent = 'Chargement...';

                fetch(`/admin/manager/${managerId}/basculer-statut`, {
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
@endsection