<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Affiche toujours le formulaire de recherche, même si une session existe
        return view('client.recherche-ticket');
    }

    public function rechercher(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');

        $ticket = Ticket::where(function ($query) use ($email) {
            $query->whereHas('reservation', fn ($q) => $q->where('client_mail', $email))
                  ->orWhereHas('reservation.superClient', fn ($q) => $q->where('email', $email));
        })
        ->latest()
        ->first();

        if (!$ticket) {
            return redirect()->route('ticket')->with('erreur', 'Aucun ticket trouvé pour cet email.');
        }

        session(['dernier_client_mail' => $email]);
        return redirect()->route('ticket.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['reservation.service.categorie', 'reservation.superClient', 'reservation.client']);

        $file = Ticket::with(['reservation.service'])
            ->whereDate('date_file', today())
            ->whereIn('statut', ['en_file', 'appele', 'en_cours', 'retard_decale'])
            ->orderBy('position')
            ->orderBy('created_at')
            ->get();

        $queryMesTickets = Ticket::with(['reservation.service', 'reservation.superClient', 'reservation.client'])
            ->whereDate('date_file', today())
            ->orderBy('created_at', 'desc');

        if ($ticket->reservation->superclient_id) {
            $queryMesTickets->whereHas('reservation', fn ($q) => $q->where('superclient_id', $ticket->reservation->superclient_id));
        } else {
            $queryMesTickets->whereHas('reservation', fn ($q) => $q->where('client_mail', $ticket->reservation->client_mail));
        }

        $mesTickets = $queryMesTickets->get();

        $tempsRestantSecondes = 0;

        if (in_array($ticket->statut, ['en_attente', 'en_file', 'appele', 'retard_decale'])) {
            $position = $file->search(fn ($t) => $t->id === $ticket->id);

            if ($position !== false && $position > 0) {
                $totalMinutes = 0;
                foreach ($file->slice(0, $position) as $t) {
                    $duree = $t->reservation->service->duree ?? '00:00:00';
                    [$h, $m, $s] = array_pad(explode(':', $duree), 3, 0);
                    $totalMinutes += ($h * 60) + $m + ($s / 60);
                }
                $tempsRestantSecondes = (int) ($totalMinutes * 60);
            }
        }

        return view('client.ticket', compact('ticket', 'file', 'mesTickets', 'tempsRestantSecondes'));
    }

    public function annuler(Request $request, Ticket $ticket)
    {
        if (in_array($ticket->statut, ['termine', 'annule', 'no_show', 'en_cours'])) {
            return redirect()->route('ticket.show', $ticket)->with('erreur', 'Ce ticket ne peut plus être annulé.');
        }

        $ticket->update(['statut' => 'annule']);
        return redirect()->route('ticket.show', $ticket)->with('succes', 'Votre ticket a été annulé.');
    }
}