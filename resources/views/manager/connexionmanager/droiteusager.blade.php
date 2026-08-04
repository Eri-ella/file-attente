<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Liste des profils usager</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des profils usager</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class="border border-[#222D52]/50">
                    <tr class="text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal p-4">Nom</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody id="corps-tableau">
                    @forelse ($profils as $usager)
                        <tr class="border border-[#222D52]/50" data-id="{{ $usager->id }}">
                            <td class="py-4 text-gray-800 p-4">
                                <input
                                    type="text"
                                    id="nom-{{ $usager->id }}"
                                    value="{{ $usager->nom }}"
                                    readonly
                                    onblur="sauvegarderNom(this)"
                                    onkeydown="verifierEntree(event, this)"
                                    class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 read-only:text-gray-800"
                                >
                            </td>
                            <td class="py-4 text-gray-800 statut uppercase">{{ $usager->statut ?? 'actif' }}</td>
                            <td class="py-4">
                                <button onclick="basculerStatut(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">
                                    {{ (strtolower($usager->statut ?? 'actif') === 'actif') ? 'Suspendre' : 'Activer' }}
                                </button>
                            </td>
                            <td class="py-4">
                                <button onclick="modifierNom(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="ligne-vide">
                            <td colspan="4" class="py-8 text-center text-gray-400">Aucun profil usager enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="py-4 text-center">
                            <button onclick="ajouterProfilEnLigne()" class="border border-[#222D52]/50 px-4 py-2 text-sm hover:bg-gray-50 rounded">
                                + Ajouter un profil usager
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </main>
        <script>
            // Gère l'activation ou la suspension d'un profil usager avec mise à jour visuelle instantanée
            function basculerStatut(bouton) {
                const ligne = bouton.closest('tr');
                const id = ligne.getAttribute('data-id');
                const celluleStatut = ligne.querySelector('.statut');
                
                if (!id) return;

                fetch(`/manager/profil-usager/${id}/statut`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        celluleStatut.textContent = data.nouveau_statut.toUpperCase();
                        bouton.textContent = data.nouveau_statut === 'actif' ? 'Suspendre' : 'Activer';
                    } else {
                        alert("Erreur lors de la modification du statut.");
                    }
                })
                .catch(err => {
                    console.error("Erreur:", err);
                    alert("Impossible de joindre le serveur pour modifier le statut.");
                });
            }

            // Rend le champ éditable au clic sur Modifier
            function modifierNom(bouton) {
                const ligne = bouton.closest('tr');
                const champNom = ligne.querySelector('input');
                champNom.readOnly = false;
                champNom.focus();
                champNom.select();
            }

            // Valide la modification et retire le focus avec la touche Entrée
            function verifierEntree(evenement, champ) {
                if (evenement.key === 'Enter') {
                    champ.blur();
                }
            }

            // Sauvegarde la modification du nom (AJAX)
            function sauvegarderNom(champ) {
                const ligne = champ.closest('tr');
                const id = ligne.getAttribute('data-id');
                const nouveauNom = champ.value.trim();

                if (!id || champ.readOnly) return;
                champ.readOnly = true;

                fetch(`/manager/profil-usager/${id}/modifier`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ nom: nouveauNom })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.message || "Erreur de sauvegarde.");
                        window.location.reload();
                    }
                })
                .catch(err => console.error("Erreur:", err));
            }

            // Crée la ligne de saisie temporaire dans le tableau
            function ajouterProfilEnLigne() {
                const corpsTableau = document.getElementById('corps-tableau');
                const ligneVide = document.querySelector('.ligne-vide');
                if (ligneVide) ligneVide.remove();

                const nouvelleLigne = document.createElement('tr');
                nouvelleLigne.className = 'border border-[#222D52]/50 temporary-row';
                nouvelleLigne.innerHTML = `
                    <td class="py-4 text-gray-800 p-4">
                        <input
                            type="text"
                            placeholder="Nom du profil usager..."
                            onkeydown="creerProfilSurEntree(event, this)"
                            class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1"
                        >
                    </td>
                    <td class="py-4 text-gray-800 statut uppercase">ACTIF</td>
                    <td class="py-4 text-center text-xs text-gray-400" colspan="2">
                        Appuyez sur Entrée pour enregistrer
                    </td>
                `;
                corpsTableau.appendChild(nouvelleLigne);
                nouvelleLigne.querySelector('input').focus();
            }

            // Enregistre en BDD au clic sur Entrée et injecte DIRECTEMENT les boutons d'action
                // Enregistre en BDD au clic sur Entrée et injecte DIRECTEMENT les boutons d'action
            function creerProfilSurEntree(evenement, champ) {
                if (evenement.key === 'Enter') {
                    const nomProfil = champ.value.trim();
                    if (!nomProfil) return;

                    champ.disabled = true;

                    // CORRECTION ABSOLUE : Génération de l'URL exacte interprétée nativement par Laravel
                    fetch("{{ url('/manager/profil-usager/store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ nom: nomProfil })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.profil) {
                            const ligne = champ.closest('tr');
                            
                            // 1. On attribue l'id MySQL récupéré à la ligne HTML
                            ligne.setAttribute('data-id', data.profil.id);
                            ligne.classList.remove('temporary-row');

                            // 2. On fige le champ input pour le rendre readonly
                            champ.id = `nom-${data.profil.id}`;
                            champ.disabled = false;
                            champ.readOnly = true;
                            champ.removeAttribute('onkeydown');
                            champ.onblur = function() { sauvegarderNom(this); };
                            champ.onkeydown = function(e) { verifierEntree(e, this); };
                            champ.className = "w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 read-only:text-gray-800";

                            // 3. On remplace le texte d'aide par les boutons réels
                            ligne.removeChild(ligne.lastElementChild);

                            const tdStatut = document.createElement('td');
                            tdStatut.className = 'py-4';
                            tdStatut.innerHTML = `<button onclick="basculerStatut(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">Suspendre</button>`;
                            
                            const tdModifier = document.createElement('td');
                            tdModifier.className = 'py-4';
                            tdModifier.innerHTML = `<button onclick="modifierNom(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">Modifier</button>`;

                            ligne.appendChild(tdStatut);
                            ligne.appendChild(tdModifier);
                        } else {
                            champ.disabled = false;
                            alert(data.message || "Erreur lors de la création.");
                        }
                    })
                    .catch(err => {
                        champ.disabled = false;
                        console.error("Erreur de routage :", err);
                        alert("Impossible de joindre le serveur. Vérifiez la correspondance des routes Laravel.");
                    });
                }
            }
        </script>

    </body>
</html>
