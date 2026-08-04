<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Historique des tickets</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">

        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50">
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Historique des tickets</h1>
            <table class="w-full text-left text-sm bg-[#FDFFFF] border border-[#222D52]/50">
                <thead>
                    <tr class="text-[#222D52]/70 border-b border-[#222D52]/50">
                        <th class="pb-2 font-normal">Ticket</th>
                        <th class="pb-2 font-normal">Service</th>
                        <th class="pb-2 font-normal">Date</th>
                        <th class="pb-2 font-normal">Heure</th>
                        <th class="pb-2 font-normal">E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class="border-b border-[#222D52]/20">
                            <td class="py-4 text-gray-800 font-bold">{{ $ticket->numero }}</td>
                            <td class="py-4 text-gray-800">{{ $ticket->service->nom ?? 'Service inconnu' }}</td>
                            <td class="py-4 text-gray-800">{{ optional($ticket->reservation)->date ? \Carbon\Carbon::parse($ticket->reservation->date)->format('d/m/Y') : '—' }}</td>
                            <td class="py-4 text-gray-800">{{ optional($ticket->reservation)->heure_souhaite ?? $ticket->debut ?? '—' }}</td>
                            <td class="py-4 text-gray-800">{{ optional(optional($ticket->reservation)->superClient)->email ?? optional($ticket->reservation)->client_mail ?? $ticket->client_mail ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-400">Aucun ticket historique trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </main>
    </body>
</html>