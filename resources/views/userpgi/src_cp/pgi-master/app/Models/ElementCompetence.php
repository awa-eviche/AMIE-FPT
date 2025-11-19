<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementCompetence extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "matiere_id",
        "metier_id",

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


    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }

}


