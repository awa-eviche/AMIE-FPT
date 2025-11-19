<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    public function etatWorkflows()
    {
        return $this->hasMany(EtatWorkflow::class);
    }

    public function typeDemande()
    {
        return $this->belongsTo(TypeDemande::class);
    }

    protected $fillable = [
        "code",
        "libelle",
        "description",
        "estActif",
        "type_demande_id"
    ];
}
