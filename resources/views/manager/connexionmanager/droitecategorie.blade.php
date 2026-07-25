@php
    $categories = [
        ['nom' => 'Etat Cicil,Citoyenneté et identité','statut' => 'actif'],
        ['nom' => 'Etat Cicil,Citoyenneté et identité','statut' => 'actif'],
        ['nom' => 'Etat Cicil,Citoyenneté et identité','statut' => 'actif'],
    ];
@endphp
 
 
<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Liste des catégories</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des catégories</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class=" border border-[#222D52]/50">
                    <tr class=" text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal ">Nom</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody id="corps-tableau">
                    @foreach ($categories as $categorie)
                        <tr class=" border border-[#222D52]/50">
                            <td class="py-4 text-gray-800">
                                  <input
                                    type="text"
                                    id="nom-{{ $loop->index }}"
                                    value="{{ $categorie['nom'] }}"
                                    readonly
                                    class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1 readonly:text-gray-800"
                                >
                            </td>
                            <td class="py-4 text-gray-800 statut">{{ $categorie['statut'] }}</td>
                            <td class="py-4">
                                <button onclick="basculerStatut(this)" class="border border-[#222D52]/50  px-4 py-1.5 text-sm hover:bg-gray-50">
                                    Suspendre
                                </button>
                            </td>
                             <td class="py-4">
                                <button onclick="modifierNom(this)" class="border border-[#222D52]/50  px-4 py-1.5 text-sm hover:bg-gray-50">
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="py-4 text-center">
                            <button onclick="ajouterCategorie()" class="border border-[#222D52]/50 px-4 py-2 text-sm hover:bg-gray-50 rounded">
                                + Ajouter une catégorie
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
 
        </main>
        <script>
            function basculerStatut(bouton) {
                
                const ligne = bouton.closest('tr');
                const celluleStatut = ligne.querySelector('.statut');
 
                const estActif = celluleStatut.textContent.trim() === 'actif';
 
                if (estActif) {
                    celluleStatut.textContent = "inactif";
                } else {
                    celluleStatut.textContent = "actif";
                };
 
                if(estActif){
                    bouton.textContent = "Activer"
                }
                else{
                    bouton.textContent = "Suspendre"
                };
            }
 
            function modifierNom(bouton) {
                const ligne = bouton.closest('tr');
                const champNom = ligne.querySelector('input');
 
                champNom.readOnly = false;
                champNom.focus();
                champNom.select();
            }
 
            function ajouterCategorie() {
                const corpsTableau = document.getElementById('corps-tableau');
 
                
                const nouvelleLigne = document.createElement('tr');
                nouvelleLigne.className = 'border border-[#222D52]/50';
                nouvelleLigne.innerHTML = `
                    <td class="py-4 text-gray-800">
                        <input
                            type="text"
                            value=""
                            placeholder="Nom de la catégorie"
                            class="w-full bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-[#222D52] rounded px-1"
                        >
                    </td>
                    <td class="py-4 text-gray-800 statut">actif</td>
                    <td class="py-4">
                        <button onclick="basculerStatut(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">
                            Suspendre
                        </button>
                    </td>
                    <td class="py-4">
                        <button onclick="modifierNom(this)" class="border border-[#222D52]/50 px-4 py-1.5 text-sm hover:bg-gray-50">
                            Modifier
                        </button>
                    </td>
                `;
 
                corpsTableau.appendChild(nouvelleLigne);
 
                nouvelleLigne.querySelector('input').focus();
            }
        </script>
    </body>
</html>
 