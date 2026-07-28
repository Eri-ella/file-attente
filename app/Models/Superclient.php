<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuperClient extends Model
{
    use HasFactory;

    protected $table = 'superclients';
 
    protected $fillable = [
        'nom', 
        'prenom', 
        'age', 
        'date_de_naissance', 
        'sexe', 
        'email', 
        'mot_de_passe', 
        'numero',
    ];
 
    protected $hidden = ['mot_de_passe'];

      public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
 
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

  
}