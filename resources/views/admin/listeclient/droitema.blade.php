@php
    $managers= [
        ['nom' => 'Jean Houessou', 'identifiant' => 'jeandev@gmail.com', 'telephone' => '019601020501', 'statut' => 'actif'],
    ];
@endphp
@extends('layouts.admin')
@section('content')
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des Managers</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class=" border border-[#222D52]/50">
                    <tr class=" text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal">Nom</th>
                        <th class="pb-2 font-normal">identitifiant</th>
                        <th class="pb-2 font-normal">Téléphone</th>
                        <th class="pb-2 font-normal">Statut</th>
                        <th class="pb-2 font-normal"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managers as $manager )
                        <tr class=" border border-[#222D52]/50">
                            <td class="py-4 text-gray-800">{{ $manager['nom'] }}</td>
                            <td class="py-4 text-gray-800">{{ $manager['identifiant'] }}</td>
                            <td class="py-4 text-gray-800">{{ $manager['telephone'] }}</td>
                            <td class="py-4 text-gray-800 statut">{{ $manager['statut'] }}</td>
                            <td class="py-4">
                                <button onclick="basculerStatut(this)" class="border border-[#222D52]/50  px-4 py-1.5 text-sm hover:bg-gray-50">
                                    Suspendre
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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
        </script>
    </body>
@endsection