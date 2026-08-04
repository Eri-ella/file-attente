<?php

namespace App\Http\Controllers\Front; 
use App\Http\Controllers\Controller; 
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;
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
            'heure_souhaite' => 'nullable|date_format:H:i',
            'nombre_tickets' => 'required|integer|min:1',
        ]);

        $clientMail = null;

        if (! $estSuperClientConnecte) {
            $client = Client::firstOrCreate(['mail' => $donnees['client_mail']]);
            $clientMail = $client->mail;
        }

        $date = $donnees['date'] ?? now()->toDateString();
        $heureDemande = $donnees['heure_souhaite'] ? Carbon::parse($donnees['heure_souhaite']) : null;

        if ($heureDemande) {
            if (Reservation::where('service_id', $service->id)
                ->where('date', $date)
                ->where('heure_souhaite', $heureDemande->format('H:i'))
                ->exists()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['heure_souhaite' => 'Ce créneau est déjà réservé pour ce service. Choisissez une autre heure.']);
            }
        }

        $heure = $heureDemande
            ?? ($date === now()->toDateString() ? Carbon::now() : Carbon::parse('08:00'));

        for ($i = 0; $i < $donnees['nombre_tickets']; $i++) {
            $heure = $this->obtenirProchainCreneau($service, $date, $heure);

            Reservation::create([
                'service_id' => $service->id,
                'date' => $date,
                'heure_souhaite' => $heure->format('H:i'),
                'superclient_id' => $estSuperClientConnecte ? session('superclient_id') : null,
                'client_mail' => $clientMail,
            ]);

            $heure = $heure->copy()->addMinutes(Ticket::dureeEnMinutes($service->duree));
        }

        return redirect()
            ->route('reservation.create', $service)
            ->with('succes', 'Réservation confirmée !');
    }

    private function obtenirProchainCreneau(Service $service, string $date, Carbon $heure): Carbon
    {
        $creneau = $heure->copy()->second(0);

        while (Reservation::where('service_id', $service->id)
            ->where('date', $date)
            ->where('heure_souhaite', $creneau->format('H:i'))
            ->exists()) {
            $creneau->addMinutes(Ticket::dureeEnMinutes($service->duree));
        }

        return $creneau;
    }
}