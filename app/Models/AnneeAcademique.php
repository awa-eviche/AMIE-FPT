<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AnneeAcademique extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "annee1",
        "annee2",
        "dateDebut",
        "dateFin",
        "is_open"
      
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

  
    public function indicateurs()
    {
        return $this->hasMany(Indicateur::class, 'anneeAcademique_id');
    }
}
