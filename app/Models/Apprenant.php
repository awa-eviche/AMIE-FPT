<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Etablissement;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Apprenant extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'telephone',
        'email',
        'nomTuteur',
        'prenomTuteur',
        'numTelTuteur',
        'situationMatrimoniale',
        'prenomPere',
        'nomPere',
        'prenomMere',
        'nomMere',
        'dateInsertion',
        'autoEmploi',
        'emploiSalarie',
        'etablissement_id',
        'isDeleted',
        'commune_id',
        'sexe',
       
        'nationalite',
        'matricule',

    ];

    
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
        
    }
    
}
