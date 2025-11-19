<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\NiveauEtude;
use App\Models\Metier;
use App\Models\ElementCompetence;
class Competence extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "niveau_etude_id",
        "metier_id",
              "type",
        "description",
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function niveau_etude()
    {
        return $this->belongsTo(NiveauEtude::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }
       public function elementCompetences()
    {
        return $this->hasMany(ElementCompetence::class);
    }
    public function criteres()
{
    return $this->hasMany(Critere::class);
}

}
