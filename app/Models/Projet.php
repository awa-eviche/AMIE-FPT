<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Projet extends Model
{
    use HasFactory;

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

 

    public function niveau()
    {
        return $this->belongsTo(NiveauEtude::class, 'niveau_etude_id');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }


    protected $fillable = [
        "type_demande",
        "etablissement_id",
        "filiere_id",
        "niveau_etude_id",
        "demande_id",
        "ancienne_adresse_etablissement",
        "nouvelle_adresse_etablissement",
        "nouvelle_denomination_etablissement",
        "ancienne_denomination_etablissement",
        "annee_academique_id",
        "nom",
        "prenom",
        "aire"
    ];


    protected $casts = [
        'aire' => 'array'
    ];

}
