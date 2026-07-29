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
        'date',
        'heure_souhaite'];

    public function client(): BelongsTo {
        return $this->BelongsTo(Client::class);
    }

    public function super_client(): BelongsTo {
        return $this->BelongsTo(Superclient::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
