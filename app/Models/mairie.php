<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class mairie extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'telephone',
        'main',
        'heure_ouvert_matin',
        'heure_ouvert_soir',
        'heure_ferme_matin',
        'heure_ferme_soir',
    ];

     public function managers(): HasMany
    {
        return $this->hasMany(manager::class);
    }
}
