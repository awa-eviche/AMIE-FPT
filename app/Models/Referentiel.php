<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referentiel extends Model
{
    protected $fillable = [
        'metier_id',
       
        'type_referentiel',
        'titre',
        'fichier',
       
    ];

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }

   

    public function niveaux()
{
    return $this->belongsToMany(NiveauEtude::class, 'niveau_referentiel');
}
}