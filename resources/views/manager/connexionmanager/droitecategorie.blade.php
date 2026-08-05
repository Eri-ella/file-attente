<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Liste des catégories</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des catégories</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class=" border border-[#222D52]/50">
                    <tr class=" text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal">Nom</th>
                        <th class="pb-2 font-normal">Lettre</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody id="corps-tableau">
                    @forelse ($categories as $categorie)
                        <tr class="border border-[#222D52]/50" data-id="{{ $categorie->id }}">
                            <td class="py-4 text-gray-800">
                                  <input
                                    type="text"
                                    data-field="nom"
                                    id="nom-{{ $categorie->id }}"
                                    value="{{ $categorie->nom }}"
                                    readonly
                                    onblur="sauvegarderCategorie(this)"
                                    onkeydown="verifierEntree(event, this)"
                                    class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 read-only:text-gray-800"
                                >
                            </td>
                            <td class="py-4 text-gray-800">
                                  <input
                                    type="text"
                                    maxlength="1"
                                    pattern="[A-Za-z]"
                                    placeholder="A"
                                    data-field="lettre"
                                    id="lettre-{{ $categorie->id }}"
                                    value="{{ $categorie->lettre }}"
                                    readonly
                                    onblur="sauvegarderCategorie(this)"
                                    onkeydown="verifierEntree(event, this)"
                                    class="w-16 bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 text-center read-only:text-gray-800"
                                >
                            </td>
                            <td class="py-4 text-gray-800 statut">{{ $categorie->statut ?? 'actif' }}</td>
                            <td class="py-4">
                                <button onclick="basculerStatut(this)" class="border border-[#222D52]/50  px-4 py-1.5 text-sm hover:bg-gray-50">
                                    {{ (strtolower($categorie->statut ?? 'actif') === 'actif') ? 'Suspendre' : 'Activer' }}
                                </button>
                            </td>
                             <td class="py-4">
                                <button onclick="modifierCategorie(this)" class="border border-[#222D52]/50  px-4 py-1.5 text-sm hover:bg-gray-50">
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="ligne-vide">
                            <td colspan="5" class="py-8 text-center text-gray-400">Aucune catégorie enregistrée pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="py-4 text-center">
                            <button onclick="ajouterCategorie()" class="border border-[#222D52]/50 px-4 py-2 text-sm hover:bg-gray-50 rounded">
                                + Ajouter une catégorie
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
 
        </main>
        <script>
            const CATEGORIE_STORE_URL = "{{ route('manager.categorie.store') }}";
            const CATEGORIE_MODIFIER_BASE = '/manager/categorie';
            const CATEGORIE_STATUT_BASE = '/manager/categorie';

            function basculerStatut(bouton) {
                const ligne = bouton.closest('tr');
                const id = ligne.getAttribute('data-id');
                const celluleStatut = ligne.querySelector('.statut');
                const estActif = celluleStatut.textContent.trim().toLowerCase() === 'actif';

                if (!id) {
                    celluleStatut.textContent = estActif ? 'inactif' : 'actif';
                    bouton.textContent = estActif ? 'Activer' : 'Suspendre';
                    return;
                }

                fetch(`${CATEGORIE_STATUT_BASE}/${id}/statut`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(`${response.status}: ${text}`); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        celluleStatut.textContent = data.nouveau_statut.toUpperCase();
                        bouton.textContent = data.nouveau_statut === 'actif' ? 'Suspendre' : 'Activer';
                    } else {
                        alert(data.message || "Erreur lors de la modification du statut.");
                    }
                })
                .catch(err => {
                    console.error("Erreur:", err);
                    alert("Impossible de joindre le serveur pour modifier le statut. Code: " + err.message);
                });
            }

            function modifierCategorie(bouton) {
                const ligne = bouton.closest('tr');
                const champNom = ligne.querySelector('input[data-field="nom"]');
                const champLettre = ligne.querySelector('input[data-field="lettre"]');

                champNom.readOnly = false;
                champLettre.readOnly = false;
                champNom.focus();
                champNom.select();
            }

            function verifierEntree(evenement, champ) {
                if (evenement.key === 'Enter') {
                    champ.blur();
                }
            }

            function sauvegarderCategorie(champ) {
                const ligne = champ.closest('tr');
                const id = ligne.getAttribute('data-id');
                const champNom = ligne.querySelector('input[data-field="nom"]');
                const champLettre = ligne.querySelector('input[data-field="lettre"]');
                const nouveauNom = champNom.value.trim();
                const nouvelleLettre = champLettre.value.trim().toUpperCase();

                if (!id || champ.readOnly) return;
                champNom.readOnly = true;
                champLettre.readOnly = true;

                fetch(`${CATEGORIE_MODIFIER_BASE}/${id}/modifier`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ nom: nouveauNom, lettre: nouvelleLettre })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(`${response.status}: ${text}`); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        alert(data.message || "Erreur de sauvegarde.");
                        window.location.reload();
                    }
                })
                .catch(err => {
                    console.error("Erreur:", err);
                    alert("Erreur de sauvegarde : " + err.message);
                });
            }

            function ajouterCategorie() {
                const corpsTableau = document.getElementById('corps-tableau');
                const ligneVide = document.querySelector('.ligne-vide');
                if (ligneVide) ligneVide.remove();

                const nouvelleLigne = document.createElement('tr');
                nouvelleLigne.className = 'border border-[#222D52]/50 temporary-row';
                nouvelleLigne.innerHTML = `
                    <td class="py-4 text-gray-800">
                        <input
                            type="text"
                            placeholder="Nom de la catégorie"
                            onkeydown="creerCategorieSurEntree(event, this)"
                            class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1"
                            data-field="nom"
                        >
                    </td>
                    <td class="py-4 text-gray-800">
                        <input
                            type="text"
                            placeholder="A"
                            maxlength="1"
                            pattern="[A-Za-z]"
                            onkeydown="creerCategorieSurEntree(event, this)"
                            class="w-16 bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 text-center"
                            data-field="lettre"
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

            function creerCategorieSurEntree(evenement, champ) {
                if (evenement.key === 'Enter') {
                    const ligne = champ.closest('tr');
                    const nomCategorie = ligne.querySelector('input[data-field="nom"]').value.trim();
                    const lettreCategorie = ligne.querySelector('input[data-field="lettre"]').value.trim().toUpperCase();
                    if (!nomCategorie || !lettreCategorie) {
                        return;
                    }

                    champ.disabled = true;

                    fetch(CATEGORIE_STORE_URL, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ nom: nomCategorie, lettre: lettreCategorie })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(`${response.status}: ${text}`); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.categorie) {
                            const ligne = champ.closest('tr');
                            ligne.setAttribute('data-id', data.categorie.id);
                            ligne.classList.remove('temporary-row');

                            ligne.innerHTML = `
                                <td class="py-4 text-gray-800">
                                    <input
                                        type="text"
                                        data-field="nom"
                                        id="nom-${data.categorie.id}"
                                        value="${data.categorie.nom}"
                                        readonly
                                        onblur="sauvegarderCategorie(this)"
                                        onkeydown="verifierEntree(event, this)"
                                        class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 read-only:text-gray-800"
                                    >
                                </td>
                                <td class="py-4 text-gray-800">
                                    <input
                                        type="text"
                                        data-field="lettre"
                                        id="lettre-${data.categorie.id}"
                                        value="${data.categorie.lettre}"
                                        readonly
                                        onblur="sauvegarderCategorie(this)"
                                        onkeydown="verifierEntree(event, this)"
                                        class="w-16 bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 text-center read-only:text-gray-800"
                                    >
                                </td>
                                <td class="py-4 text-gray-800 statut">${data.categorie.statut.toUpperCase()}</td>
                                <td class="py-4">
                                    <button onclick="basculerStatut(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">Suspendre</button>
                                </td>
                                <td class="py-4">
                                    <button onclick="modifierCategorie(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">Modifier</button>
                                </td>
                            `;
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
 