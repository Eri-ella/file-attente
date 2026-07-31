<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 
        'description',
        'critere_technique',
        'duree',
        'cout',
        'mairie_id', 
        'profil_usager_id',       
        'categorie_id',    
    ];

    public function tickets(): HasMany {
        return $this->hasMany(Ticket::class);
    }

    public function mairie(): BelongsTo {
        return $this->belongsTo(Mairie::class); 
    }

    public function profil_usager(): BelongsTo {
        return $this->belongsTo(ProfilUsager::class); 
    }

    public function categorie(): BelongsTo {
        return $this->belongsTo(Categorie::class); 
    }
}
