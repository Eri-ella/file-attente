<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\HasOne;
 
class Mairie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'adresse',
        'telephone',
        'mail',
        'heure_ouvert_matin',
        'heure_ouvert_soir',
        'heure_ferme_matin',
        'heure_ferme_soir',
    ];
 
    public function managers(): HasOne
    {
        return $this->hasOne(Manager::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
