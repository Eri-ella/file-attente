<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'heure'];

    public function client(): BelongsTo {
        return $this->BelongsTo(Client::class);
    }

    public function super_client(): BelongsTo {
        return $this->BelongsTo(Superclient::class);
    }
}
