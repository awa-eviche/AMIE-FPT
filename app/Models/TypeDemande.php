<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TypeDemande extends Model
{
    use HasFactory;

    public function workflow()
    {
        return $this->hasOne(Workflow::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'type_demande_id');
    }

    public function cas_particuliers()
    {
        return $this->hasMany(Cas_particulier::class, 'cas_particulier_id');
    }

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function typeDemandeParent()
    {
        return $this->belongsTo(TypeDemande::class, 'type_demande_id');
    }

    public function typeDemandeFilles()
    {
        return $this->hasMany(TypeDemande::class, 'type_demande_id');
    }

    protected $fillable = [
        "code",
        "libelle",
        "description",
    ];
}
