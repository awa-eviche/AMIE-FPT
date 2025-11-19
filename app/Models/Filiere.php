<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Secteur;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "description",
        "secteur_id",
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    /**
     * Get all of the metiiers for the Filiere
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metiers(): HasMany
    {
        return $this->hasMany(Metier::class, 'filiere_id');
    }
}
