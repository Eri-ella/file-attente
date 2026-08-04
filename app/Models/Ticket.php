@extends('layouts.client')

@section('client-content')

@php
    $statutLabel = match($ticket->statut) {
        'en_cours'  => 'Votre ticket est en cours de traitement',
        'appele'    => 'Veuillez vous rendre au guichet',
        'termine'   => 'Ticket terminé',
        'annule'    => 'Ticket annulé',
        'no_show'   => 'Ticket expiré',
        default     => 'Votre tour approche',
    };
@endphp

<main class="flex flex-col items-center text-(--primary-color) min-h-screen">

    <div class="flex flex-col items-center justify-center w-full min-h-50 bg-(--primary-color) gap-5">
        <p class="text-(--highlight-color)">{{ $statutLabel }}</p>
        <p id="compteur" class="text-(--white-color) text-7xl font-medium" data-secondes="{{ $tempsRestantSecondes }}">--:--:--</p>
        <p class="text-(--white-color)">
            @if(in_array($ticket->statut, ['en_attente', 'en_file', 'appele'])) Temps restant avant le passage
            @elseif($ticket->statut === 'en_cours') En cours de traitement
            @else -- @endif
        </p>
    </div>

    <div class="flex w-full justify-center gap-10 mb-10 px-4 flex-wrap">
        <table class="min-w-70">
            <tbody class="flex flex-col gap-5">
                <tr class="flex justify-between"><td>Service</td><td>{{ $ticket->service->nom ?? 'N/A' }}</td></tr>
                <tr class="flex justify-between"><td>Date</td><td>{{ $ticket->date_file ? $ticket->date_file->format('d F Y') : 'Non définie' }}</td></tr>
                <tr class="flex justify-between"><td>Heure estimée</td><td>{{ $ticket->heure_estimee ? $ticket->heure_estimee->format('H:i') : '--:--' }}</td></tr>
                <tr class="flex justify-between"><td>Titulaire</td><td>{{ $ticket->client_mail ?? $ticket->superclient->email ?? 'N/A' }}</td></tr>
            </tbody>
        </table>
        <div class="flex flex-col justify-center h-[160px] items-center bg-[#d2b58975] border-l-3 border-(--primary-color) border-dashed min-w-30 gap-2 mb-10">
            <p class="text-4xl font-medium">{{ $ticket->numero ?? '---' }}</p>
            <p class="text-xs">Votre ticket</p>
        </div>
    </div>

    @if($file->count())
    <div class="w-full max-w-2xl px-4 mb-10">
        <h3 class="text-xl font-medium mb-4">File d'attente</h3>
        <table class="w-full border-1 border-(--primary-color)">
            <tbody>
                @foreach($file as $t)
                    @php $estEnCours = $t->statut === 'en_cours'; $estLeMien = $t->id === $ticket->id; @endphp
                    <tr class="{{ $estEnCours ? 'bg-[#d2b58975]' : ($estLeMien ? 'bg-[#222D5215]' : '') }} border-b border-gray-200">
                        <td class="font-light p-3 w-16 text-center">{{ $loop->iteration }}</td>
                        <td class="p-3">Ticket {{ $t->numero }}</td>
                        <td class="p-3 uppercase text-sm">
                            @if($estEnCours) <span class="bg-[#d2b58975] px-2 py-1">En cours</span>
                            @elseif($t->statut === 'appele') <span class="bg-yellow-100 px-2 py-1">Appelé</span>
                            @else <span class="text-gray-600">En attente</span> @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($mesTickets->count())
    <div class="flex flex-col justify-center gap-5 w-full max-w-2xl px-4 mb-10">
        <h3 class="text-xl font-medium">Mes tickets</h3>
        <table class="w-full border-1 border-(--primary-color)">
            <tbody>
                @foreach($mesTickets as $t)
                    <tr class="border-b border-gray-200">
                        <td class="p-3">Ticket {{ $t->numero }}</td>
                        <td class="p-3">
                            @if($t->statut === 'en_attente') <span class="bg-[#222D5275] text-white px-2 py-1 text-sm">Non confirmé</span>
                            @elseif($t->statut === 'annule') <span class="bg-red-100 text-red-800 px-2 py-1 text-sm">Annulé</span>
                            @elseif($t->statut === 'termine') <span class="bg-green-100 text-green-800 px-2 py-1 text-sm">Terminé</span>
                            @elseif($t->statut === 'no_show') <span class="bg-gray-200 text-gray-700 px-2 py-1 text-sm">Expiré</span>
                            @else <span class="text-sm">{{ $t->date_file ? $t->date_file->format('d/m/Y') : '-' }}</span> @endif
                        </td>
                        <td class="p-3 text-right">
                            @if(in_array($t->statut, ['en_attente', 'en_file']))
                                <form action="{{ route('ticket.annuler', $t) }}" method="POST" onsubmit="return confirm('Annuler ce ticket ?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm underline">Annuler</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(session('succes')) <div class="mb-10 text-green-700 bg-green-100 px-4 py-2 rounded">{{ session('succes') }}</div> @endif
    @if(session('erreur')) <div class="mb-10 text-red-700 bg-red-100 px-4 py-2 rounded">{{ session('erreur') }}</div> @endif

</main>

<script>
(function() {
    const c = document.getElementById('compteur'); if (!c) return;
    let s = parseInt(c.dataset.secondes) || 0;
    const fmt = t => { const h=Math.floor(t/3600).toString().padStart(2,'0'), m=Math.floor((t%3600)/60).toString().padStart(2,'0'), sec=(t%60).toString().padStart(2,'0'); return `${h}:${m}:${sec}`; };
    const tick = () => { if(s>0){s--;c.textContent=fmt(s);}else{c.textContent='00:00:00';} };
    if(s>0){c.textContent=fmt(s);setInterval(tick,1000);}else{c.textContent='--:--:--';}
    setTimeout(()=>location.reload(),60000);
})();
</script>

@endsection