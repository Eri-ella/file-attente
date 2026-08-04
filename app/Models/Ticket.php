<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'statut',
        'service_id',
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

    /* ========== RELATIONS ========== */

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function superclient(): BelongsTo
    {
        return $this->belongsTo(Superclient::class, 'superclient_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }

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
