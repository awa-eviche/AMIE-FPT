<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\NiveauEtude;
use App\Models\Etablissement;


class NiveauEtudeEtablissement extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
       
        "niveau_etude_id",
        "etablissement_id",
        "approved",
        "isDeleted"
    
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function niveauEtude()
    {
        return $this->belongsTo(NiveauEtude::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
   public function metier()
{
    return $this->belongsTo(Metier::class);
}
}
