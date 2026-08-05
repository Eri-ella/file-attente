<?php

namespace App\Http\Controllers\Front; 
use App\Http\Controllers\Controller; 
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Service;
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
            'heure_souhaite' => 'nullable',
            'nombre_tickets' => 'required|integer|min:1',
        ]);

        $clientMail = null;
        if (! $estSuperClientConnecte) {
            $client = Client::firstOrCreate(['mail' => $donnees['client_mail']]);
            $clientMail = $client->mail;
        }

        $lettre = $service->categorie->lettre ?? 'C' . $service->categorie_id;
        $today  = now()->toDateString();

        $countExistant = Ticket::whereDate('date_file', $today)
            ->whereHas('reservation.service', fn ($q) => $q->where('categorie_id', $service->categorie_id))
            ->count();

        $dernierTicket = null;

        for ($i = 0; $i < $donnees['nombre_tickets']; $i++) {
            $reservation = Reservation::create([
                'service_id'     => $service->id,
                'date'           => $donnees['date'] ?? now()->toDateString(),
                'heure_souhaite' => $donnees['heure_souhaite'] ?? now()->toTimeString(),
                'superclient_id' => $estSuperClientConnecte ? session('superclient_id') : null,
                'client_mail'    => $clientMail,
            ]);

            $numero = $lettre . '-' . str_pad($countExistant + $i + 1, 3, '0', STR_PAD_LEFT);

            $dernierTicket = Ticket::creerDepuisReservation($reservation, $numero);
        }

        if ($clientMail) {
            session(['dernier_client_mail' => $clientMail]);
        }

        if ($request->ajax()) {
            return view('client.reservation-content', [
                'service' => $service,
                'succes' => 'Réservation confirmée !',
                'ticket' => $dernierTicket,
            ]);
        }

        return redirect()->route('ticket.show', $dernierTicket)->with('succes', 'Réservation confirmée !');
    }
}