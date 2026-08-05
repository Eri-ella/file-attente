<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Notifications\TicketRappelNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifierRappelsTicket extends Command
{
    protected $signature = 'tickets:verifier-rappels';
    protected $description = 'Vérifier et envoyer les rappels de tickets 10 min avant le passage';

    public function handle(): int
    {
        $now = Carbon::now();

        $debut = $now->copy()->addMinutes(9)->format('H:i:s');
        $fin   = $now->copy()->addMinutes(10)->format('H:i:s');

        $tickets = Ticket::where('statut', 'en_file')
            ->whereTime('heure_estimee', '>=', $debut)
            ->whereTime('heure_estimee', '<', $fin)
            ->get();

        foreach ($tickets as $ticket) {
            if ($ticket->emailDestinataire) {
                $ticket->notify(new TicketRappelNotification($ticket));
                $this->info("Rappel envoye pour le ticket {$ticket->numero} ({$ticket->emailDestinataire})");
            }
        }

        if ($tickets->isEmpty()) {
            $this->comment('Aucun rappel a envoyer pour le moment.');
        }

        return self::SUCCESS;
    }
}