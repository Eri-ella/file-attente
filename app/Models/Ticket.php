<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory; // ← Ajouter cette ligne

    protected $fillable = [
        'numero',
        'statut',
        'superclient_id',
        'client_mail',
        'reservation_id',
        'position',
        'heure_estimee',
        'heure_passage',
        'date_file',
    ];

    protected $casts = [
        'heure_estimee' => 'datetime:H:i',
        'heure_passage' => 'datetime:H:i',
        'date_file'     => 'date',
    ];

    /* ========== RELATIONS EXISTANTES ========== */

    public function service(): BelongsTo
    {
        static::creating(function (Ticket $ticket) {
            if (empty($ticket->numero)) {
                $ticket->numero = static::genererNumero($ticket->service_id);
            }

            if (empty($ticket->fin) && ! empty($ticket->debut) && ! empty($ticket->service_id)) {
                $service = $ticket->service ?? Service::find($ticket->service_id);
                if ($service) {
                    $ticket->fin = static::calculerFin($ticket->debut, $service->duree);
                }
            }
        });

        static::saving(function (Ticket $ticket) {
            if (empty($ticket->fin) && ! empty($ticket->debut) && ! empty($ticket->service_id)) {
                $service = $ticket->service ?? Service::find($ticket->service_id);
                if ($service) {
                    $ticket->fin = static::calculerFin($ticket->debut, $service->duree);
                }
            }
        });
    }

    public function superclient(): BelongsTo
    {
        if ($value !== null && $value !== '') {
            return $value;
        }

        $service = $this->service;
        if (! $service) {
            return $value;
        }

        if ($this->debut) {
            return static::calculerFin($this->debut, $service->duree);
        }

        if ($this->created_at) {
            return static::calculerFin($this->created_at->format('H:i'), $service->duree);
        }

        return $value;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }

    /* ========== NOUVELLE RELATION ========== */

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /* ========== MÉTHODES ========== */

    public static function genererNumero(Service $service): string
    {
        $lettre = $service->categorie->lettre ?? 'X';
        $today  = now()->toDateString();

        $compteur = self::whereDate('date_file', $today)
            ->whereHas('service', fn ($q) => $q->where('categorie_id', $service->categorie_id))
            ->count() + 1;

        return $lettre . '-' . str_pad($compteur, 3, '0', STR_PAD_LEFT);
    }

    public static function creerDepuisReservation(Reservation $reservation): self
    {
        return self::create([
            'reservation_id' => $reservation->id,
            'numero'         => self::genererNumero($reservation->service),
            'statut'         => 'en_attente',
            'service_id'     => $reservation->service_id,
            'superclient_id' => $reservation->superclient_id,
            'client_mail'    => $reservation->client_mail,
            'date_file'      => today(),
        ]);
    }
}