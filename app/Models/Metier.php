<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Filiere;
use App\Models\FiliereEtablissement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Metier extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "filiere_id",
        "diplome_id",
        "description",
  "modalite",
          "statut_programme"
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }
    public function filiereEtablissements()
    {
        return $this->hasManyThrough(FiliereEtablissement::class, Filiere::class);
    }
    /**
     * Get the niveaux that owns the Metier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function niveaux(): HasMany
    {
        return $this->hasMany(NiveauEtude::class, 'metier_id');
    }
}
