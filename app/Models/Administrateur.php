<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Administrateur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'age',
        'date_de_naissance',
        'numero'];

    protected $hidden = ['mot_de_passe'];

    
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
