<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Demande extends Model
{
    use HasFactory;


    public function demandeParente()
    {
        return $this->belongsTo(Demande::class, 'demande_parente_id');
    }

    public function etat()
    {
        return $this->belongsTo(EtatWorkflow::class, 'etat_id');
    }

    public function accordeAgent()
    {
        return $this->belongsTo(Agent::class, 'accorded_agent_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }


    public function projets()
    {
        return $this->hasMany(Projet::class, 'demande_id');
    }


    public function typeDemande()
    {
        return $this->belongsTo(TypeDemande::class, 'type_demande_id');
    }


    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }


    public function demandeur()
    {
        return $this->belongsTo(Demandeur::class, 'demandeur_id');
    }



    public function demandeFilles()
    {
        return $this->hasMany(Demande::class, 'demande_parente_id');
    }

    /*  public function reunions()
    {
        return $this->belongsToMany(Reunion::class);
    }*/

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function suivEtats(): MorphMany
    {
        return $this->morphMany(SuiviEtat::class, 'suivi_etatable');
    }


    protected $fillable = [
        "libelle",
        "etablissement_id",
        "projet_id",
        "agent_id",
        "etat_id",
        "demandeur_id",
        "demande_parente_id",
        "type_demande_id",
        "date_depot",
        "date_expiration",
    ];
}
