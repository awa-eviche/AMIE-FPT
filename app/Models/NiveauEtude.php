<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Metier;
use App\Models\Diplome;
use App\Models\Competence;
use Illuminate\Database\Eloquent\Relations\HasMany;



class NiveauEtude extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "metier_id",
        "diplome_id",
        "description",
        "annee"
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function niveauEtudeEtablissement(): HasMany
    {
        return $this->hasMany(NiveauEtudeEtablissement::class, 'niveau_etude_id');
    }
public function competences()
    {
        return $this->hasMany(\App\Models\Competence::class, 'niveau_etude_id');
    }

    public function etablissements()
    {
        return $this->belongsToMany(
            Etablissement::class,
            'niveau_etude_etablissements',
            'niveau_etude_id',
            'etablissement_id'
        );
    }  
}
