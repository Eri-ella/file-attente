@php
    $statistiques = [
        ['valeur' => '23', 'label' => "Tickets aujourd'hui"],
        ['valeur' => '7 min', 'label' => 'Attente moyenne'],
        ['valeur' => '3', 'label' => 'Tickets en attente'],
        ['valeur' => '2', 'label' => 'Décalages'],
    ];
 
    $file = [
        ['ordre' => '01', 'ticket' => 'B-039', 'debut' => '8h00', 'fin' => '8h35', 'statut' => 'EN COURS'],
        ['ordre' => '02', 'ticket' => 'B-039', 'debut' => '8h00', 'fin' => '8h35', 'statut' => 'EN COURS'],
        ['ordre' => '03', 'ticket' => 'B-039', 'debut' => '8h00', 'fin' => '8h35', 'statut' => 'EN COURS'],
        ['ordre' => '04', 'ticket' => 'B-039', 'debut' => '8h00', 'fin' => '8h35', 'statut' => 'EN COURS'],
    ];
 
    $clientsEnAttente = [
        ['ordre' => '01', 'heure' => '8h00-8h35', 'date' => '12/12/2026'],
        ['ordre' => '02', 'heure' => '8h00-8h35', 'date' => '12/12/2026'],
        ['ordre' => '03', 'heure' => '8h00-8h35', 'date' => '12/12/2026'],
        ['ordre' => '04', 'heure' => '8h00-8h35', 'date' => '12/12/2026'],
    ];
@endphp
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
        
            {{-- ===== Cartes statistiques (carrées, bordure simple, pas d'arrondi) ===== --}}
            <div class="flex justify-between mb-10">
                @foreach ($statistiques as $stat)
                    <div class="w-36 h-36 border border-[#222D52]/20 p-4 flex flex-col justify-center bg-[#FDFFFF]">
                        <p class="text-3xl font-bold text-[#222D52] mb-2">{{ $stat['valeur'] }}</p>
                        <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        
            {{-- ===== File en cours ===== --}}
            <div class="border border-[#222D52]/20  p-6 bg-[#FDFFFF]">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">File en cours</h2>
        
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">Numéro d'ordre</th>
                            <th class="pb-2 font-normal">Numéro de ticket</th>
                            <th class="pb-2 font-normal">Heure de debut</th>
                            <th class="pb-2 font-normal">Heure de fin</th>
                            <th class="pb-2 font-normal">Statut</th>
                            <th class="pb-2 font-normal"></th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody id="corps-file">
                        @foreach ($file as $ticket)
                            <tr class="border-b border-[#222D52]/10">
                                <td class="py-3 text-gray-400 ordre">{{ $ticket['ordre'] }}</td>
                                <td class="py-3 text-gray-800">{{ $ticket['ticket'] }}</td>
                                <td class="py-3 text-gray-800">{{ $ticket['debut'] }}</td>
                                <td class="py-3 text-gray-800">{{ $ticket['fin'] }}</td>
                                <td class="py-3 text-gray-800 statut">{{ $ticket['statut'] }}</td>
                                <td class="py-3">
                                    <button onclick="insererAuDessus(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Insérer au dessus
                                    </button>
                                </td>
                                <td class="py-3">
                                    <button onclick="retirerTicket(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Retirer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="pt-4 text-center">
                                <button onclick="ajouterALaFile()" class="border border-[#222D52]/50 px-4 py-2 text-sm hover:bg-gray-50 rounded">
                                    Ajouter à la file
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        
            {{-- ===== Clients en attente ===== --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF] mt-10 bg-[#FDFFFF]">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">Clients en attente</h2>
        
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">Numéro d'ordre</th>
                            <th class="pb-2 font-normal">Heure souhaitée</th>
                            <th class="pb-2 font-normal">Date souhaitée</th>
                            <th class="pb-2 font-normal"></th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody id="corps-attente">
                        @foreach ($clientsEnAttente as $client)
                            <tr class="border-b border-[#222D52]/10">
                                <td class="py-3 text-gray-400 ordre">{{ $client['ordre'] }}</td>
                                <td class="py-3 text-gray-800 heure">{{ $client['heure'] }}</td>
                                <td class="py-3 text-gray-800 date">{{ $client['date'] }}</td>
                                <td class="py-3">
                                    <button onclick="ajouterALaFileDepuisAttente(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Ajouter à la file
                                    </button>
                                </td>
                                <td class="py-3">
                                    <button onclick="retirerClientAttente(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                                        Retirer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
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
            // Reconstruit les numéros d'ordre (01, 02, 03...) selon la position réelle des lignes
            function renumeroterFile() {
                const lignes = document.querySelectorAll('#corps-file tr');
                lignes.forEach(function (ligne, position) {
                    const numero = String(position + 1).padStart(2, '0');
                    ligne.querySelector('.ordre').textContent = numero;
                });
            }
        
            function retirerTicket(bouton) {
                const ligne = bouton.closest('tr');
                ligne.remove();
                renumeroterFile();
            }
        
            function creerLigneVide() {
                const nouvelleLigne = document.createElement('tr');
                nouvelleLigne.className = 'border-b border-[#222D52]/10';
                nouvelleLigne.innerHTML = `
                    <td class="py-3 text-gray-400 ordre">—</td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="N° ticket" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="Heure debut" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="Heure fin" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800 statut">EN ATTENTE</td>
                    <td class="py-3">
                        <button onclick="insererAuDessus(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                            Insérer au dessus
                        </button>
                    </td>
                    <td class="py-3">
                        <button onclick="retirerTicket(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
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
                const nouvelleLigne = creerLigneVide();
        
                corpsFile.appendChild(nouvelleLigne);
                nouvelleLigne.querySelector('input').focus();
                renumeroterFile();
            }
        
            //Clients en attente 
        
            function renumeroterAttente() {
                const lignes = document.querySelectorAll('#corps-attente tr');
                lignes.forEach(function (ligne, position) {
                    const numero = String(position + 1).padStart(2, '0');
                    ligne.querySelector('.ordre').textContent = numero;
                });
            }
        
            // Retire le client de la liste d'attente et l'envoie dans "File en cours"
            function ajouterALaFileDepuisAttente(bouton) {
                const ligneAttente = bouton.closest('tr');
        
                // Récupère les infos du client en attente avant de supprimer sa ligne
                const heureSouhaitee = ligneAttente.querySelector('.heure').textContent.trim();
        
                // "8h00-8h35" devient un tableau ["8h00", "8h35"] grâce à split('-')
                const heures = heureSouhaitee.split('-');
                const heureDebut = heures[0];
                const heureFin = heures[1];
        
                // Construit la nouvelle ligne pour le tableau "File en cours"
                const nouvelleLigneFile = document.createElement('tr');
                nouvelleLigneFile.className = 'border-b border-[#222D52]/10';
                nouvelleLigneFile.innerHTML = `
                    <td class="py-3 text-gray-400 ordre">—</td>
                    <td class="py-3 text-gray-800">
                        <input type="text" placeholder="N° ticket" class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1">
                    </td>
                    <td class="py-3 text-gray-800">${heureDebut}</td>
                    <td class="py-3 text-gray-800">${heureFin}</td>
                    <td class="py-3 text-gray-800 statut">EN COURS</td>
                    <td class="py-3">
                        <button onclick="insererAuDessus(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                            Insérer au dessus
                        </button>
                    </td>
                    <td class="py-3">
                        <button onclick="retirerTicket(this)" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">
                            Retirer
                        </button>
                    </td>
                `;
        
                // Ajoute le client à la fin de "File en cours"
                document.getElementById('corps-file').appendChild(nouvelleLigneFile);
                renumeroterFile();
        
                // Retire le client de "Clients en attente"
                ligneAttente.remove();
                renumeroterAttente();
            }
        
            // Retire simplement un client de la liste d'attente, sans l'envoyer dans la file
            function retirerClientAttente(bouton) {
                const ligne = bouton.closest('tr');
                ligne.remove();
                renumeroterAttente();
            }
        </script>
    
    </body>
</html>
 