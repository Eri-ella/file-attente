<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = ['email'];

    public function tickets(): HasMany {
        return $this->hasMany(Ticket::class);
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class);
    }
}
