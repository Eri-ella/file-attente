<?php

namespace App\Http\Controllers\Front; 
use App\Http\Controllers\Controller; 
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ReservationController extends Controller
{
    public function create(Service $service): View
    {
        return view('client.reservation', compact('service'));

    }

    /**
     * IMPORTANT : suppose qu'un Super_Client connecté a son id en session
     * (ex: session(['superclient_id' => $superClient->id]) au moment de sa connexion).
     * Sinon, on traite la demande comme un Client anonyme identifié par son email.
     */
    public function store(Request $request, Service $service): RedirectResponse
    {
        $estSuperClientConnecte = session()->has('superclient_id');

        $donnees = $request->validate([
            'client_mail' => $estSuperClientConnecte ? 'nullable|email' : 'required|email',
            'date' => 'nullable|date',
            'heure_souhaite' => 'nullable',
            'nombre_tickets' => 'required|integer|min:1',
        ]);

        $clientMail = null;

        if (! $estSuperClientConnecte) {
            // La contrainte de clé étrangère exige que l'email existe déjà dans "clients"
            // AVANT de pouvoir l'utiliser dans "reservations" → on le crée s'il n'existe pas.
            $client = Client::firstOrCreate(['mail' => $donnees['client_mail']]);
            $clientMail = $client->mail;
        }

        // Une réservation par ticket demandé (nombre_tickets = combien de lignes créer)
        for ($i = 0; $i < $donnees['nombre_tickets']; $i++) {
            Reservation::create([
                'service_id' => $service->id,
                'date' => $donnees['date'] ?? now()->toDateString(),
                'heure_souhaite' => $donnees['heure_souhaite'] ?? now()->toTimeString(),
                'superclient_id' => $estSuperClientConnecte ? session('superclient_id') : null,
                'client_mail' => $clientMail,
            ]);
        }

        return redirect()
            ->route('reservation.create', $service)
            ->with('succes', 'Réservation confirmée !');
    }
}