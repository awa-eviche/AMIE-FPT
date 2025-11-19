<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Metier;
use App\Models\Diplome;


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


  
}
