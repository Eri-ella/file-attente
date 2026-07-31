<?php
 
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Manager extends Authenticatable
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
 
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
    
    public function mairie(): BelongsTo
    {
        return $this->belongsTo(Mairie::class);
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function sendPasswordResetNotification($token)
    {
        $url = route('manager.password.reset', ['token' => $token, 'email' => $this->email]);
        $this->notify(new \App\Notifications\ResetPasswordLink($url, 'manager'));
    }
}
