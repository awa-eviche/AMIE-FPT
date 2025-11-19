<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Secteur extends Model
{
    use HasFactory;


    protected $fillable = [
        "code",
        "libelle",
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
}
