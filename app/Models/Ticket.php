<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'reservation_id',
        'numero',
        'statut',
        'position',
        'nombre_retards',
        'heure_estimee',
        'heure_passage',
        'date_file',
    ];

    protected $casts = [
        'heure_estimee'  => 'datetime:H:i',
        'heure_passage'  => 'datetime:H:i',
        'date_file'      => 'date',
        'nombre_retards' => 'integer',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public static function genererNumero(Service $service, int $indexJour): string
    {
        $lettre = $service->categorie->lettre ?? 'C' . $service->categorie_id;
        return $lettre . '-' . str_pad($indexJour, 3, '0', STR_PAD_LEFT);
    }

    public static function creerDepuisReservation(Reservation $reservation, string $numero): self
    {
        return self::create([
            'reservation_id' => $reservation->id,
            'numero'         => $numero,
            'statut'         => 'en_attente',
            'date_file'      => today(),
        ]);
    }

    /**
     * Retourne l'email à notifier (superclient prioritaire, sinon client invité).
     */
    public function getEmailDestinataireAttribute(): ?string
    {
        return $this->reservation->superclient?->email
            ?? $this->reservation->client_mail;
    }

    /**
     * Adresse email utilisée par le système de notification Laravel.
     */
    public function routeNotificationForMail(): ?string
    {
        return $this->emailDestinataire;
    }
}