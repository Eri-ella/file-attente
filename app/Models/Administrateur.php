<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Notifications\Notifiable;

class Administrateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'age',
        'date_de_naissance',
        'sexe',
        'email',
        'mot_de_passe',
        'numero'];

    protected $hidden = ['mot_de_passe'];

    
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function sendPasswordResetNotification($token)
    {
        $url = route('admin.password.reset', ['token' => $token, 'email' => $this->email]);
        $this->notify(new \App\Notifications\ResetPasswordLink($url, 'administrateur'));
    }

    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::make($value);
    }
}
