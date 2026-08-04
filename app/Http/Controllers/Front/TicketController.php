<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        $ticket->load(['service.categorie', 'superclient', 'reservation.service.categorie']);

        // File d'attente du jour
        $file = Ticket::with('service.categorie')
            ->whereDate('date_file', today())
            ->whereIn('statut', ['en_file', 'appele', 'en_cours'])
            ->orderBy('position')
            ->orderBy('created_at')
            ->get();

        // Mes tickets (même identité)
        $queryMesTickets = Ticket::with(['service.categorie'])
            ->whereDate('date_file', today())
            ->orderBy('created_at', 'desc');

        if ($ticket->superclient_id) {
            $queryMesTickets->where('superclient_id', $ticket->superclient_id);
        } else {
            $queryMesTickets->where('client_mail', $ticket->client_mail);
        }

        $mesTickets = $queryMesTickets->get();

        // Temps restant estimé
        $tempsRestantSecondes = 0;

        if (in_array($ticket->statut, ['en_attente', 'en_file', 'appele'])) {
            $position = $file->search(fn ($t) => $t->id === $ticket->id);

            if ($position !== false && $position > 0) {
                $totalMinutes = 0;
                foreach ($file->slice(0, $position) as $t) {
                    $duree = $t->service->duree ?? '00:00:00';
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
            return redirect()->route('ticket.show', $ticket)
                ->with('erreur', 'Ce ticket ne peut plus être annulé.');
        }

        $ticket->update(['statut' => 'annule']);

        return redirect()->route('ticket.show', $ticket)
            ->with('succes', 'Votre ticket a été annulé.');
    }

        /**
     * Page "Voir mes tickets" — recherche par email
     */
    public function index(Request $request)
    {
        // Si le client vient de réserver, on a son email en session
        if (session('dernier_client_mail')) {
            $ticket = Ticket::where('client_mail', session('dernier_client_mail'))
                ->latest()
                ->first();

            if ($ticket) {
                return redirect()->route('ticket.show', $ticket);
            }
        }

        // Si superclient connecté
        if (session('superclient_id')) {
            $ticket = Ticket::where('superclient_id', session('superclient_id'))
                ->latest()
                ->first();

            if ($ticket) {
                return redirect()->route('ticket.show', $ticket);
            }
        }

        return view('client.recherche-ticket');
    }

    /**
     * Traite la recherche par email
     */
    public function rechercher(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $ticket = Ticket::where('client_mail', $email)
            ->orWhereHas('superclient', function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->latest()
            ->first();

        if (!$ticket) {
            return redirect()->route('ticket')
                ->with('erreur', 'Aucun ticket trouvé pour cet email.');
        }

        // Stocke en session pour les prochaines visites
        session(['dernier_client_mail' => $email]);

        return redirect()->route('ticket.show', $ticket);
    }
}