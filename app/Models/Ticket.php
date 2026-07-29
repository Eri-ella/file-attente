<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'statut'];

    public function reservation(): BelongsTo {
        return $this->BelongsTo(Reservation::class);
    }

    public function service(): BelongsTo {
        return $this->BelongsTo(Service::class);
    }

}
