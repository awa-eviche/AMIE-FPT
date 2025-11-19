<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critere extends Model
{
    use HasFactory;
    protected $fillable = [
        "element_competence_id",
        "code",
        "libelle",
        "description",
        "competence_id",
       "niveau_etude_id",
    ];

    public function elementCompetence()
	{
	    return $this->belongsTo(ElementCompetence::class);
	}

    public function competence()
	{
	    return $this->belongsTo(Competence::class);
	}

 public function niveauetude()
	{
	    return $this->belongsTo(NiveauEtude::class);
	}
}
