@php
    $tickets = [
        ['TICKET' => 'B_040', 'SERVICE' => 'Carte identité', 'DATE' => '14 juin 2026', 'MAIL_CLIENT' => 'Dyldev@gmail.com'],
        ['TICKET' => 'B_040', 'SERVICE' => 'Renouvellement de passeport', 'DATE' => '14 juin 2026', 'MAIL_CLIENT' => 'Lapoisse@gmail.com'],
        ['TICKET' => 'B_040', 'SERVICE' => 'Carte identité', 'DATE' => '14 mai 2026', 'MAIL_CLIENT' => 'loiselle25@gmail.com'],
    ];
@endphp 
<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Historique des tickets</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">

        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50">
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Liste des clients</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF]">
                <thead class=" border border-[#222D52]/50">
                    <tr class=" text-[#222D52]/70 border border-[#222D52]/50">
                        <th class="pb-2 font-normal">TICKET</th>
                        <th class="pb-2 font-normal">SERVICE</th>
                        <th class="pb-2 font-normal">DATE</th>
                        <th class="pb-2 font-normal">MAIL_CLIENT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class=" border border-[#222D52]/50">
                            <td class="py-4 text-gray-800">{{ $ticket['TICKET'] }}</td>
                            <td class="py-4 text-gray-800">{{ $ticket['SERVICE'] }}</td>
                            <td class="py-4 text-gray-800">{{ $ticket['DATE'] }}</td>
                            <td class="py-4 text-gray-800">{{ $ticket['MAIL_CLIENT'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </main>
    </body>
</html>