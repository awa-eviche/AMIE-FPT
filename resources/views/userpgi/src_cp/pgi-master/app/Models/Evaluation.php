<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Evaluation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        
        "inscription_id",
        "matiere_id",
        "note_cc",
        "semestre",
        "appreciation",
        "note_composition",
    

       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

   
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
