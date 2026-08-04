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
use App\Models\Categorie;
use App\Models\ProfilUsager;
use App\Models\Ticket;

class ReservationController extends Controller
{
    public function create(Request $request, Service $service): View
    {
        if ($request->ajax()) {
            return view('client.reservation-content', compact('service'));
        }

        $services = Service::all();
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();

        return view('client.reservation', compact('service', 'services', 'categories', 'profils'));
    }

    public function store(Request $request, Service $service)
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

        $dernierTicket = null;

        for ($i = 0; $i < $donnees['nombre_tickets']; $i++) {
            $reservation = Reservation::create([
                'service_id'     => $service->id,
                'date'           => $donnees['date'] ?? now()->toDateString(),
                'heure_souhaite' => $donnees['heure_souhaite'] ?? now()->toTimeString(),
                'superclient_id' => $estSuperClientConnecte ? session('superclient_id') : null,
                'client_mail'    => $clientMail,
            ]);

            $dernierTicket = Ticket::creerDepuisReservation($reservation);
        }

        if ($request->ajax()) {
            return view('client.reservation-content', [
                'service' => $service,
                'succes' => 'Réservation confirmée !',
                'ticket' => $dernierTicket,
            ]);
        }

        // Stocke l'email en session pour retrouver le ticket plus tard
        if ($clientMail) {
            session(['dernier_client_mail' => $clientMail]);
        }

        return redirect()->route('ticket.show', $dernierTicket)->with('succes', 'Réservation confirmée !');
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