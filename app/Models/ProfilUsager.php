<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilUsager extends Model
{
    use HasFactory;

    // SÉCURITÉ : Indique explicitement le nom de votre table SQL dans phpMyAdmin
    protected $table = 'profil_usagers';
 
    protected $fillable = [
        'nom',
        'statut',
    ];
 
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}


