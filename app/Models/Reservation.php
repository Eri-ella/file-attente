<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'date',
        'heure_souhaite',
        'superclient_id',
        'client_mail',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Accéder directement à la catégorie liée au service de cette réservation
     */
    public function categorie(): HasOneThrough
    {
        return $this->hasOneThrough(
            Categorie::class,
            Service::class,
            'id',           // Clé locale sur la table services (l'id du service)
            'id',           // Clé locale sur la table categories (l'id de la catégorie)
            'service_id',   // Clé étrangère sur la table reservations
            'categorie_id'  // Clé étrangère sur la table services
        );
    }

    /**
     * belongsTo avec 3 arguments car la clé n'est PAS "client_id" mais "client_mail",
     * et elle pointe vers "mail" dans clients (pas "id").
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }

    public function superClient(): BelongsTo
    {
        return $this->belongsTo(SuperClient::class, 'superclient_id');
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function estFaiteParUnSuperClient(): bool
    {
        return $this->superclient_id !== null;
    }
}
