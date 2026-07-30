<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrateur extends Authenticatable
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
}
