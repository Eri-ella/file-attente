<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'mail';  // "mail" remplace "id" comme identifiant unique
    public $incrementing = false;    // ce n'est pas un nombre auto-incrémenté
    protected $keyType = 'string';   // le type de la clé est du texte, pas un entier

    protected $fillable = ['mail'];

    public function reservations(): HasMany
    {
        // 'client_mail' précisé explicitement, car Eloquent devinerait "client_id" par défaut
        return $this->hasMany(Reservation::class, 'client_mail', 'mail');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'client_mail', 'mail');
    }
}
