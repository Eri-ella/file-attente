@php
    $statistiques = [
        ['valeur' => $ticketsAujourdhui, 'label' => "Tickets aujourd'hui"],
        ['valeur' => $attenteMoyenne, 'label' => 'Attente moyenne'],
        ['valeur' => $ticketsEnAttenteCount, 'label' => 'Tickets en attente'],
        ['valeur' => $decalages, 'label' => 'Décalages'],
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

            @if(session('succes'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('succes') }}</div>
            @endif
            @if(session('erreur'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('erreur') }}</div>
            @endif

            {{-- Stats --}}
            <div class="flex justify-between mb-10">
                @foreach ($statistiques as $stat)
                    <div class="w-36 h-36 border border-[#222D52]/20 p-4 flex flex-col justify-center bg-[#FDFFFF]">
                        <p class="text-3xl font-bold text-[#222D52] mb-2">{{ $stat['valeur'] }}</p>
                        <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- File en cours --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF] mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-[#222D52]">File en cours</h2>
                    <form action="{{ route('manager.ticket.appelerSuivant') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-4 py-2 rounded">
                            Appeler le suivant
                        </button>
                    </form>
                </div>

                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">N° ordre</th>
                            <th class="pb-2 font-normal">Ticket</th>
                            <th class="pb-2 font-normal">Service</th>
                            <th class="pb-2 font-normal">Heure estimée</th>
                            <th class="pb-2 font-normal">Statut</th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($file as $t)
                            <tr class="border-b border-[#222D52]/10">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 text-gray-800 font-medium">{{ $t->numero }}</td>
                                <td class="py-3 text-gray-800">{{ $t->service->nom ?? 'N/A' }}</td>
                                <td class="py-3 text-gray-800">
                                    {{ $t->heure_estimee ? \Carbon\Carbon::parse($t->heure_estimee)->format('H:i') : '--:--' }}
                                </td>
                                <td class="py-3">
                                    @if($t->statut === 'en_cours')
                                        <span class="bg-[#D2B589]/50 px-2 py-1 text-xs">EN COURS</span>
                                    @elseif($t->statut === 'appele')
                                        <span class="bg-yellow-100 px-2 py-1 text-xs">APPELÉ</span>
                                    @else
                                        <span class="text-gray-600 text-xs">EN FILE</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($t->statut === 'en_file')
                                        <form action="{{ route('manager.ticket.retirer', $t) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="border border-[#222D52]/50 px-3 py-1.5 text-sm hover:bg-gray-50">Retirer</button>
                                        </form>
                                    @elseif($t->statut === 'en_cours')
                                        <form action="{{ route('manager.ticket.terminer', $t) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="border border-green-600 text-green-700 px-3 py-1.5 text-sm hover:bg-green-50">Terminer</button>
                                        </form>
                                        <form action="{{ route('manager.ticket.noShow', $t) }}" method="POST" class="inline ml-1">
                                            @csrf
                                            <button type="submit" class="border border-red-400 text-red-600 px-3 py-1.5 text-sm hover:bg-red-50">Absent</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-6 text-center text-gray-500">Aucun ticket en file</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Clients en attente (réservations non validées) --}}
            <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF]">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">Clients en attente de validation</h2>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#222D52]/20">
                            <th class="pb-2 font-normal">N°</th>
                            <th class="pb-2 font-normal">Ticket</th>
                            <th class="pb-2 font-normal">Service</th>
                            <th class="pb-2 font-normal">Heure souhaitée</th>
                            <th class="pb-2 font-normal">Date souhaitée</th>
                            <th class="pb-2 font-normal">Titulaire</th>
                            <th class="pb-2 font-normal"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientsEnAttente as $t)
                            <tr class="border-b border-[#222D52]/10">
                                <td class="py-3 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3 text-gray-800 font-medium">{{ $t->numero }}</td>
                                <td class="py-3 text-gray-800">{{ $t->service->nom ?? 'N/A' }}</td>
                                <td class="py-3 text-gray-800">
                                    {{ $t->reservation && $t->reservation->heure_souhaite ? \Carbon\Carbon::parse($t->reservation->heure_souhaite)->format('H:i') : '--:--' }}
                                </td>
                                <td class="py-3 text-gray-800">
                                    {{ $t->reservation && $t->reservation->date ? \Carbon\Carbon::parse($t->reservation->date)->format('d/m/Y') : '--' }}
                                </td>
                                <td class="py-3 text-gray-800">
                                    {{ $t->client_mail ?? $t->superclient->email ?? 'N/A' }}
                                </td>
                                <td class="py-3">
                                    <form action="{{ route('manager.ticket.ajouterFile', $t) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-[#222D52] hover:bg-[#18213f] text-white px-3 py-1.5 text-sm rounded">Ajouter à la file</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-6 text-center text-gray-500">Aucun client en attente</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>
