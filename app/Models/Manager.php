<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Manager extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'nom',
        'prenom',
        'age', 
        'date_de_naissance', 
        'sexe', 
        'email', 
        'mot_de_passe', 
        'numero', 
        'mairie_id',
    ];
 
    protected $hidden = ['mot_de_passe'];
 
    public function mairie(): BelongsTo
    {
        return $this->belongsTo(Mairie::class);
    }
}
