<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ← Ajouter cette ligne
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Reservation;
use App\Models\Service;

class Ticket extends Model
{
    use HasFactory; // ← Ajouter cette ligne

    protected $fillable = [
        'numero',
        'statut',
        'superclient_id',
        'client_mail',
        'service_id',
        'reservation_id',
        'debut',
        'fin',
    ];

    protected static function booted(): void
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

    public function getFinAttribute($value)
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

    public static function calculerFin(string $debut, string|int $duree): string
    {
        $minutes = static::dureeEnMinutes($duree);

        return \Carbon\Carbon::parse($debut)->addMinutes($minutes)->format('H:i');
    }

    public static function dureeEnMinutes(string|int $duree): int
    {
        if (is_int($duree)) {
            return $duree;
        }

        if (is_numeric($duree)) {
            return (int) $duree;
        }

        $parts = explode(':', $duree);
        if (count($parts) >= 2) {
            $hours = (int) $parts[0];
            $minutes = (int) $parts[1];
            return ($hours * 60) + $minutes;
        }

        return 0;
    }

    /**
     * Génère le prochain numéro pour un service donné : A-001, A-002... pour service_id=1,
     * B-001, B-002... pour service_id=2, etc.
     */
    public static function genererNumero(int $serviceId): string
    {
        $lettre = chr(64 + $serviceId);

        $dernierNumero = static::where('service_id', $serviceId)
            ->whereNotNull('numero')
            ->orderBy('id', 'desc')
            ->value('numero');

        if (! $dernierNumero || ! preg_match('/^(?:[A-Z])-([0-9]{3})$/', $dernierNumero, $matches)) {
            $compteur = 1;
        } else {
            $compteur = (int) $matches[1] + 1;
        }

        $numero = str_pad((string) $compteur, 3, '0', STR_PAD_LEFT);

        return "{$lettre}-{$numero}";
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }

    public function superClient(): BelongsTo
    {
        return $this->belongsTo(SuperClient::class, 'superclient_id');
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}