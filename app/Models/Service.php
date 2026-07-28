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
        'categorie',
        'description',
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
