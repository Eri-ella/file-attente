<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'numero',
        'statut'];

    public function client(): BelongsTo {
        return $this->BelongsTo(Client::class);
    }

    public function service(): BelongsTo {
        return $this->BelongsTo(Service::class);
    }

    public function super_client(): BelongsTo {
        return $this->BelongsTo(Superclient::class);
    }
}
