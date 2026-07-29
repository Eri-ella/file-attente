<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilUsager extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'nom',
        'statut',
    ];
 
    public function mairie(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
