<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de bord</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full">

        <main class="p-10 bg-[#F9F8F5]">

            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Tableau de bord</h1>

            {{-- ===== Cartes statistiques (maintenant dynamiques, plus de @php codé en dur) ===== --}}
            <div class="flex justify-between mb-10">
                @foreach ($statistiques as $stat)
                    <div class="w-36 h-36 border border-[#222D52]/20 p-4 flex flex-col justify-center bg-[#FDFFFF]">
                        <p class="text-3xl font-bold text-[#222D52] mb-2">{{ $stat['valeur'] }}</p>
                        <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ===== File en cours (Tableau du HAUT) ===== --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF]">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">File en cours</h2>

                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">Numéro d'ordre</th>
                            <th class="pb-2 font-normal">Numéro de ticket</th>
                            <th class="pb-2 font-normal">Catégorie</th>
                            <th class="pb-2 font-normal">Heure de debut</th>
                            <th class="pb-2 font-normal">Heure de fin</th>
                            <th class="pb-2 font-normal">Statut</th>
                            <th class="pb-2 font-normal"></th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody id="corps-file">
                        @forelse ($fileEnCours as $index => $res)
                            <tr class="border-b border-[#222D52]/10" data-id="{{ $res->id }}" data-service-id="{{ $res->ticket->service_id ?? '' }}">
                                <td class="py-3 text-gray-400 ordre">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3 text-gray-800 font-bold">{{ $res->ticket->numero ?? '—' }}</td>
                                <td class="py-3 text-gray-800">{{ $res->categorie->nom ?? 'Général' }}</td>
                                <td class="py-3 text-gray-800">{{ $res->ticket->debut ?? '—' }}</td>
                                <td class="py-3 text-gray-800">{{ $res->ticket->fin ?? '—' }}</td>
                                <td class="py-3 text-gray-800 statut">EN COURS</td>
                                <td class="py-3 text-right">
                                    <button onclick="insererAuDessus(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50 mr-2">
                                        Insérer au dessus
                                    </button>
                                </td>
                                <td class="py-3 text-right">
                                    <button onclick="retirerTicket(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Retirer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="ligne-vide-file">
                                <td colspan="8" class="py-4 text-center text-gray-400">Aucun client actif dans la file.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="pt-4 text-center">
                                <button onclick="ajouterALaFile()" class="border border-[#222D52]/50 px-4 py-2 text-sm hover:bg-gray-50 rounded">
                                    Ajouter à la file
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- ===== Clients en attente (Tableau du BAS) ===== --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF] mt-10">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">Clients en attente</h2>

                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">Numéro d'ordre</th>
                            <th class="pb-2 font-normal">Client / Catégorie</th>
                            <th class="pb-2 font-normal">Heure souhaitée</th>
                            <th class="pb-2 font-normal">Date souhaitée</th>
                            <th class="pb-2 font-normal"></th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody id="corps-attente">
                        @forelse ($clientsEnAttente as $index => $client)
                            <tr class="border-b border-[#222D52]/10" data-id="{{ $client->id }}">
                                <td class="py-3 text-gray-400 ordre">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3 text-gray-800 font-medium">
                                    <span class="nom-categorie font-bold block text-[#222D52]">{{ $client->categorie->nom ?? 'Standard' }}</span>
                                    <span class="text-xs text-gray-500">{{ $client->client_mail }}</span>
                                    @if($client->estFaiteParUnSuperClient())
                                        <span class="text-[10px] bg-amber-100 text-amber-700 px-1 py-0.5 rounded font-bold ml-1">SUPERCLIENT</span>
                                    @endif
                                </td>
                                <td class="py-3 text-gray-800 heure">{{ \Carbon\Carbon::parse($client->heure_souhaite)->format('H:i') }}</td>
                                <td class="py-3 text-gray-800 date">{{ \Carbon\Carbon::parse($client->date)->format('d/m/Y') }}</td>
                                <td class="py-3 text-right">
                                    <button onclick="ajouterALaFileDepuisAttente(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50 bg-white">
                                        Ajouter à la file
                                    </button>
                                </td>
                                <td class="py-3 text-right">
                                    <button onclick="retirerClientAttente(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Retirer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-400">Aucune demande de réservation en attente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== Section Créneaux libérés ===== --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF] mt-10 max-w-2xl w-full mr-auto rounded-lg shadow-sm">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">Créneaux libérés récemment</h2>
                <div class="bg-[#D2B589]/40 p-4 text-sm text-[#222D52] mb-4 border-l-4 border-[#222D52]">
                    Un ticket annulé à 13:45 a libéré 15 min. 4 clients éligibles ont été notifiés automatiquement.
                </div>
                <p class="text-sm text-gray-600">
                    Optimisation intelligente : 1 place réattribuée avec succès à 13:52.
                </p>
            </div>

        </main>
        <script>
            function renumeroterFile() {
                const lignes = document.querySelectorAll('#corps-file tr');
                let realIndex = 1;
                lignes.forEach(function (ligne) {
                    if(!ligne.classList.contains('ligne-vide-file')) {
                        const numero = String(realIndex).padStart(2, '0');
                        const ordreField = ligne.querySelector('.ordre');
                        if (ordreField) ordreField.textContent = numero;
                        realIndex++;
                    }
                });

                const corpsFile = document.getElementById('corps-file');
                if (lignes.length === 0) {
                    corpsFile.innerHTML = `
                        <tr class="ligne-vide-file">
                            <td colspan="8" class="py-4 text-center text-gray-400">Aucun client actif dans la file.</td>
                        </tr>
                    `;
                }
            }

            function retirerTicket(bouton) {
                const ligneFile = bouton.closest('tr');
                const ticketId = ligneFile.getAttribute('data-id');

                // Sécurité : si c'est une ligne vide créée à la main sans ID, on l'enlève juste de l'écran
                if (!ticketId) {
                    ligneFile.remove();
                    renumeroterFile();
                    return;
                }

                // Appel asynchrone Fetch vers la nouvelle route Laravel d'annulation
                fetch(`/manager/ticket/${ticketId}/annuler`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Supprime la ligne du tableau du haut
                        ligneFile.remove();
                        renumeroterFile();
                        
                        // Recharge la page proprement pour recalculer les tableaux et les statistiques
                        window.location.reload();
                    } else {
                        alert("Une erreur est survenue lors de l'annulation du ticket.");
                    }
                })
                .catch(err => {
                    console.error("Erreur:", err);
                    alert("Impossible de joindre le serveur. Vérifiez vos routes.");
                });
            }


            function creerLigneVide() {
                const nouvelleLigne = document.createElement('tr');
                nouvelleLigne.className = 'border-b border-[#222D52]/10';
                nouvelleLigne.innerHTML = `
                    <td class="py-3 text-gray-400 ordre">—</td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="N° ticket" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800">Général</td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="Heure debut" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="Heure fin" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800 statut">EN ATTENTE</td>
                    <td class="py-3 text-right">
                        <button onclick="insererAuDessus(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                            Insérer au dessus
                        </button>
                    </td>
                    <td class="py-3 text-right">
                        <button onclick="retirerTicket(this)" class="w-36 whitespace-nowrap border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                            Retirer
                        </button>
                    </td>
                `;
                return nouvelleLigne;
            }

            function insererAuDessus(bouton) {
                const ligneActuelle = bouton.closest('tr');
                const nouvelleLigne = creerLigneVide();

                ligneActuelle.parentNode.insertBefore(nouvelleLigne, ligneActuelle);
                nouvelleLigne.querySelector('input').focus();
                renumeroterFile();
            }

            function ajouterALaFile() {
                const corpsFile = document.getElementById('corps-file');
                const ligneVide = document.querySelector('.ligne-vide-file');
                if(ligneVide) ligneVide.remove();

                const nouvelleLigne = creerLigneVide();
                corpsFile.appendChild(nouvelleLigne);
                nouvelleLigne.querySelector('input').focus();
                renumeroterFile();
            }

            function renumeroterAttente() {
                const lignes = document.querySelectorAll('#corps-attente tr');
                lignes.forEach(function (ligne, position) {
                    const numero = String(position + 1).padStart(2, '0');
                    const ordreField = ligne.querySelector('.ordre');
                    if (ordreField) ordreField.textContent = numero;
                });
            }

            function ajouterALaFileDepuisAttente(bouton) {
                const ligneAttente = bouton.closest('tr');
                const reservationId = ligneAttente.getAttribute('data-id');

                fetch(`/manager/reservation/${reservationId}/generer-ticket`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || "Erreur lors de la création du ticket.");
                    }
                })
                .catch(err => {
                    console.error("Erreur d'envoi:", err);
                    alert("Impossible de joindre le serveur. Vérifiez votre route Laravel.");
                });
            }

            function retirerClientAttente(bouton) {
                const ligne = bouton.closest('tr');
                const reservationId = ligne.getAttribute('data-id');

                fetch(`/manager/reservation/${reservationId}/supprimer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || "Erreur lors de la suppression de la réservation.");
                    }
                })
                .catch(err => {
                    console.error("Erreur de suppression:", err);
                    alert("Impossible de joindre le serveur. Vérifiez votre route Laravel.");
                });
            }

            function insererAuDessus(bouton) {
                const ligneFile = bouton.closest('tr');
                const ticketId = ligneFile.getAttribute('data-id');

                const clientMail = prompt('E-mail du client à insérer :');
                if (!clientMail) {
                    return;
                }

                const date = prompt('Date de réservation (AAAA-MM-JJ) :', new Date().toISOString().slice(0, 10));
                if (!date) {
                    return;
                }

                const heure = prompt('Heure de début (HH:mm) :', '09:00');
                if (!heure) {
                    return;
                }

                fetch(`/manager/ticket/${ticketId}/inserer-au-dessus`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        client_mail: clientMail,
                        date: date,
                        heure_souhaite: heure,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || "Erreur lors de l'insertion du client.");
                    }
                })
                .catch(err => {
                    console.error("Erreur d'insertion:", err);
                    alert("Impossible de joindre le serveur. Vérifiez votre route Laravel.");
                });
            }
        </script>

    </body>
</html>

        