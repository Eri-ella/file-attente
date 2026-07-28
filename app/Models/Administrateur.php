<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Administrateur extends Model

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
}
