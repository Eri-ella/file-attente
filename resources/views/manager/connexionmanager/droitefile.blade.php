<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>File d'attente</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">

        @if(session('succes'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 text-center text-sm">{{ session('succes') }}</div>
        @endif
        @if(session('erreur'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 text-center text-sm">{{ session('erreur') }}</div>
        @endif

        {{-- Ticket en cours (grand bandeau) --}}
        @if($ticketEnCours)
            <div class="text-center bg-[#222D52] text-white py-8 px-4 font-medium">
                <p class="text-sm text-[#D2B589] mb-2">TICKET EN COURS DE TRAITEMENT</p>
                <h2 class="text-6xl font-bold" id="compteur-manager" data-secondes="{{ $tempsRestantSecondes }}">--:--:--</h2>
                <p class="mt-2 text-sm opacity-80">Temps estimé avant fin du traitement</p>
            </div>
            <div class="bg-[#F9F8F5]">
                <div class="flex text-center max-w-xl mx-auto py-10">
                    <div class="flex-1 p-8 space-y-4 text-left">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Service</span>
                            <span class="font-medium text-[#222D52]">{{ $ticketEnCours->service->nom ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Date</span>
                            <span class="font-medium text-[#222D52]">{{ $ticketEnCours->date_file ? $ticketEnCours->date_file->format('d F Y') : 'Non définie' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Heure début</span>
                            <span class="font-medium text-[#222D52]">{{ $ticketEnCours->heure_passage ? \Carbon\Carbon::parse($ticketEnCours->heure_passage)->format('H:i') : '--:--' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Titulaire</span>
                            <span class="font-medium text-[#222D52]">{{ $ticketEnCours->client_mail ?? $ticketEnCours->superclient->email ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="w-40 border-l-2 border-dashed border-[#222D52] bg-[#D2B589]/50 flex flex-col items-center justify-center">
                        <p class="text-3xl font-bold text-[#222D52]">{{ $ticketEnCours->numero }}</p>
                        <p class="text-xs text-[#222D52]/70 mt-1">Ticket</p>
                    </div>
                </div>
                <div class="text-center pb-6">
                    <form action="{{ route('manager.ticket.terminer', $ticketEnCours) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded mr-2">Terminer</button>
                    </form>
                    <form action="{{ route('manager.ticket.noShow', $ticketEnCours) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-6 py-2 rounded">Absent (no-show)</button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center bg-[#222D52] text-white py-12 px-4 font-medium">
                <h2 class="text-3xl mb-4">Aucun ticket en cours de traitement</h2>
                <form action="{{ route('manager.ticket.appelerSuivant') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#D2B589] hover:bg-[#c4a87d] text-[#222D52] px-8 py-3 rounded font-bold text-lg">Appeler le suivant</button>
                </form>
            </div>
        @endif

        {{-- File complète --}}
        <div class="bg-[#F9F8F5] flex-1 p-10">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-lg font-medium text-[#222D52] mb-4">File d'attente complète</h2>
                <div class="border border-[#222D52]/20 p-6 bg-[#FDFFFF]">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-[#222D52]/20">
                                <th class="pb-2 font-normal">N° ordre</th>
                                <th class="pb-2 font-normal">Numéro ticket</th>
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-6 text-center text-gray-500">File vide</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const c = document.getElementById('compteur-manager');
                if (!c) return;
                let s = parseInt(c.dataset.secondes) || 0;
                const fmt = t => { const h=Math.floor(t/3600).toString().padStart(2,'0'), m=Math.floor((t%3600)/60).toString().padStart(2,'0'), sec=(t%60).toString().padStart(2,'0'); return `${h}:${m}:${sec}`; };
                const tick = () => { if(s>0){s--;c.textContent=fmt(s);}else{c.textContent='00:00:00';} };
                if(s>0){c.textContent=fmt(s);setInterval(tick,1000);}else{c.textContent='--:--:--';}
                setTimeout(()=>location.reload(),30000);
            })();
        </script>
    </body>
</html>