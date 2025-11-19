<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\Absence;
use App\Models\AnneeAcademique;

class Inscription extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        
        "apprenant_id",
        "classe_id",
        "statut",
        "annee_academique_id",
        "dateInscription"

       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

   
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeAcademique()
{
    return $this->belongsTo(AnneeAcademique::class);
}

public function evaluations()
{
    return $this->hasMany(\App\Models\Evaluation::class, 'inscription_id', 'id');
}
public function absences()
{
    return $this->hasMany(\App\Models\Absence::class);
}
}
