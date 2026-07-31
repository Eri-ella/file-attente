@extends('layouts.client_service')
 
@section('service')
    <section class="text-(--primary-color) p-5">
        <div>
            <button class="btn-secondary mb-10" onclick="history.back()">Retour</button>
        </div>
 
        @if (session('succes'))
            <div class="bg-green-100 text-green-800 text-sm px-4 py-3 rounded mb-6">
                {{ session('succes') }}
            </div>
        @endif
 
        <!-- CORRECTION : Passage explicite de l'ID du service pour garantir la liaison dans l'URL -->
        <form method="POST" action="{{ route('reservation.store', $service->id) }}">
            @csrf
 
            <div class="flex w-full gap-10">
                <div class="flex flex-col gap-5 w-2/3">
                    <h2 class="text-4xl font-medium">{{ $service->nom }}</h2>
                    <p class="text-xs bg-[#d2b58975] p-2 border-l-3 border-(--primary-color)">Vous n'avez pas besoin de compte pour réserver. Un e-mail suffit pour recevoir votre ticket et ses notifications.</p>
                    <div class="flex flex-col">
                        <div class="flex flex-col gap-5 mb-5">
                            <label class="text-xl font-medium">Adresse e-mail</label>
                            <!-- OPTIMISATION : Si l'utilisateur est connecté via sa session, on peut pré-remplir l'e-mail -->
                            <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)"
                                   type="email" name="client_mail" id="client_mail" placeholder="jeandev@gmail.com"
                                   value="{{ old('client_mail', auth()->guard('superclient')->user()->mail ?? '') }}">
                            @error('client_mail') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex justify-between">
                            <div class="flex flex-col gap-5">
                                <label class="text-xl font-medium">Date souhaitée (optionnel)</label>
                                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)"
                                       type="date" name="date" id="date" oninput="mettreAJourRecapitulatif()">
                            </div>
                            <div class="flex flex-col gap-5">
                                <label class="text-xl font-medium">Heure souhaitée (optionnel)</label>
                                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)"
                                       type="time" name="heure_souhaite" id="heure_souhaite">
                            </div>
                        </div>
                        <p class="text-xs mb-5">Laissez l'heure vide pour obtenir le prochain créneau disponible calculé automatiquement.</p>
                        <div class="flex flex-col gap-5">
                            <label class="text-xl font-medium">Nombre de ticket(s)</label>
                            <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)"
                                   type="number" name="nombre_tickets" id="nombre_tickets" min="1" value="1"
                                   oninput="mettreAJourRecapitulatif()">
                            @error('nombre_tickets') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <p class="text-xs mb-5">Un ticket par personne à traiter au guichet.</p>
                    </div>
                </div>
 
                <div>
                    <h4 class="text-2xl font-medium mb-5">Récapitulatif</h4>
                    <table class="flex flex-col gap-5">
                        <tr class="flex justify-between border-b-1 border-(--primary-color) gap-5">
                            <td>Service</td>
                            <td>{{ $service->nom }}</td>
                        </tr>
                        <tr class="flex justify-between border-b-1 border-(--primary-color) gap-5">
                            <td>Date</td>
                            <td id="recap-date">--</td>
                        </tr>
                        <tr class="flex justify-between gap-5">
                            <td>Ticket(s)</td>
                            <td id="recap-tickets">1</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <input class="btn-primary mt-5 cursor-pointer" type="submit" value="Confirmer la réservation">
            </div>
        </form>
    </section>
 
    <script>
        function mettreAJourRecapitulatif() {
            const champDate = document.getElementById('date').value; // "AAAA-MM-JJ"
            const recapDate = document.getElementById('recap-date');
 
            if (champDate) {
                const [annee, mois, jour] = champDate.split('-');
                recapDate.textContent = `${jour}/${mois}/${annee}`;
            } else {
                recapDate.textContent = '--';
            }
 
            const champTickets = document.getElementById('nombre_tickets').value;
            document.getElementById('recap-tickets').textContent = champTickets || '1';
        }
    </script>
@endsection
