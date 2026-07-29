<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    // 1. CORRECTION : Ajout des clés obligatoires pour permettre l'insertion de données
    protected $fillable = [
        'numero',
        'statut',
        'service_id',
        'superclient_id',
        'client_mail'
    ];

    // 2. CORRECTION : Syntaxe belongsTo (b minuscule) pour lier le service
    public function service(): BelongsTo 
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // 3. AJOUT : Relation avec le Superclient
    public function superclient(): BelongsTo 
    {
        return $this->belongsTo(Superclient::class, 'superclient_id');
    }

    // 4. AJOUT : Relation avec le Client classique (via la colonne client_mail)
    public function client(): BelongsTo 
    {
        return $this->belongsTo(Client::class, 'client_mail', 'mail');
    }
}

