<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etablissement extends Model
{
    use HasFactory;
   

    // public function commune()
    // {
    //     return $this->belongsTo(Commune::class, 'commune_id');
    // }
    // public function liste(){
    //     return 
    // }
    public $timestamps = false;
    protected $fillable = [
        'telephone',
        'email',
        'sigle',
        'slogan',
        'siteWeb',
        'adresse',
        'logo',
        'nom',
        'commune_id',
        'specifite',
        'dateAutOuv',
        'numAutOuv',
        'dateRecepisseDepot',
        'numRecipisse',
        'prenomResponsable',
        'nomResponsable',
        'reference',
        'dateCreation',
        'boitePostale',
        'type',
        'statutJuridique',
        "statut",
        "is_active",
        "approved",
        "isDeleted",
        
    ];
    

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }



    /**
     * Get the indicateur that owns the Etablissement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function suiviIndicateur()
    {
        return $this->hasMany(SuiviIndicateur::class, 'etablissement_id',);
    }

    public function personnels()
    {
        return $this->hasMany(PersonnelEtablissement::class);
    }
    public function niveauxEtudes()
    {
        return $this->belongsToMany(
            NiveauEtude::class,
            'niveau_etude_etablissements',
            'etablissement_id',
            'niveau_etude_id'
        );
    }
      public function niveauEtudeEtablissements()
    {
        return $this->hasMany(NiveauEtudeEtablissement::class);
    }

public function metiers()
{
    return $this->hasManyThrough(
        Metier::class,
        NiveauEtude::class,
        'id',        // clé locale de niveau_etudes
        'id',        // clé locale de metiers
        'id',        // clé locale d’établissement
        'metier_id'  // clé étrangère de niveau_etudes
    );
}
}
