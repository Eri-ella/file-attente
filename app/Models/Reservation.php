<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'superclient_id',
        'client_mail',
        'date',
        'heure_souhaite',
        'nombre_tickets',
        'commentaire',
        'statut',
    ];

    // Relations
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function superclient(): BelongsTo
    {
        return $this->belongsTo(Superclient::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Relation avec Client (via email)
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }
}