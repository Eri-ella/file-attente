<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
