<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Filiere;
use App\Models\Etablissement;


class FiliereEtablissement extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
       
        "filiere_id",
        "etablissement_id",
    
       
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

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

}
