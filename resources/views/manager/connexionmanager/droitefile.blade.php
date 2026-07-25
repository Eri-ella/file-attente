@php
    
    $service = "Demande d'acte de mariage";
    $date = '18 juillet 2026';
    $heure = '14:20';
    $titulaire = 'dolo.chou@gmail.fr';
    $ticket = 'B-042';


    $files = [
            ['Numero ordre' => '01', 'Numero ticket' => 'B-039', 'Heure de debut' => '8h00', 'Heure de fin' => '8h35', 'statut' => 'EN COURS'],
            ['Numero ordre' => '01', 'Numero ticket' => 'B-039', 'Heure de debut' => '8h00', 'Heure de fin' => '8h35', 'statut' => 'EN COURS'],
            ['Numero ordre' => '01', 'Numero ticket' => 'B-039', 'Heure de debut' => '8h00', 'Heure de fin' => '8h35', 'statut' => 'EN COURS'],
    ];
@endphp
<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de bord</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        
            <div class="text-center bg-[#222D52] text-white   py-8 px-4 font-medium text-[#222D52] ">
                <h2 class="text-6xl">00:12:40</h2>
                <h2>Temps estimé avant le passage</h2>
            </div>
            <div class="bg-[#F9F8F5]">
                <div class="flex text-center max-w-xl mx-auto mb-16">
                    <div class="flex-1 p-8 space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Service</span>
                            <span class="font-medium text-[#222D52]">{{ $service }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Date</span>
                            <span class="font-medium text-[#222D52]">{{ $date }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Heure</span>
                            <span class="font-medium text-[#222D52]">{{ $heure }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Titulaire</span>
                            <span class="font-medium text-[#222D52]">{{ $titulaire }}</span>
                        </div>
                    </div>

                    <div class="w-40 border-l-2 border-dashed border-[#222D52] bg-[#D2B589]/50 flex flex-col items-center justify-center">
                            <p class="text-3xl font-bold text-[#222D52]">{{ $ticket }}</p>
                            <p class="text-xs text-[#222D52]/70 mt-1">Ticket</p>
                    </div>
                </div>
                    
                <div class="max-w-3xl w-full mx-auto mb-5 bg-white">
                    <div>
                        <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF] rounded-lg shadow-sm">
                            <h2 class="text-lg font-medium text-[#222D52] mb-4">File en cours</h2>
                        
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-gray-500 border-b border-[#222D52]/20">
                                        <th class="pb-2 font-normal">Numero ordre</th>
                                        <th class="pb-2 font-normal">Numero ticket</th>
                                        <th class="pb-2 font-normal">Heure de debut</th>
                                        <th class="pb-2 font-normal">Heure de fin</th>
                                        <th class="pb-2 font-normal">statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr class="border-b border-[#222D52]/10">
                                            <td class="py-3 text-gray-400 ordre">{{ $file['Numero ordre'] }}</td>
                                            <td class="py-3 text-gray-800">{{ $file['Numero ticket'] }}</td>
                                            <td class="py-3 text-gray-800">{{ $file['Heure de debut'] }}</td>
                                            <td class="py-3 text-gray-800">{{ $file['Heure de fin'] }}</td>
                                            <td class="py-3 text-gray-800 statut">{{ $file['statut'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
            
    </body>
</html>