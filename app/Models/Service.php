<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'nom', 
        'categorie',
        'profil_usager',
        'critere_technique',
        'duree',
        'cout'];

    public function tickets(): HasMany {
        return $this->hasMany(Ticket::class);
    }

    public function mairie(): BelongsTo {
        return $this->BelongsTo(Mairie::class);
    }
}
