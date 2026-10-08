<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\NiveauEtude;
use App\Models\NiveauEtudeEtablissement;

use App\Models\Etablissement;
use App\Models\AnneeAcademique;
use App\Models\Inscription;
use App\Models\PersonnelEtablissement;
class Classe extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "libelle",
        "modalite",
        "niveau_etude_id",
      
        "etablissement_id",
        "statut",

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

    public function niveau_etude_etablissement()
    {
        return $this->belongsTo(NiveauEtudeEtablissement::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function annee_academique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

   public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'classe_id');
    }


  // Tous les formateurs (historique complet)
public function formateurs()
{
    return $this->belongsToMany(
        \App\Models\PersonnelEtablissement::class,
        'formateur_etablissement',
        'classe_id',
        'personnel_etablissement_id'
    )
    ->withPivot('role')
    ->withTimestamps();
}

// Uniquement les formateurs encore actifs dans l'établissement de la classe
public function formateursActifs()
{
    return $this->formateurs()
        ->where('actif', true);
}
public function matieres()
{
    return $this->belongsToMany(Matiere::class, 'classe_formateur_matiere', 'classe_id', 'matiere_id')
                ->withPivot('formateur_id')
                ->withTimestamps();
}
}
