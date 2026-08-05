<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

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
}