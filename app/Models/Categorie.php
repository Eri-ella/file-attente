<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Categorie extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'nom',
        'statut', 
    ];
 
 
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
