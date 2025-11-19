<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuiviIndicateur extends Model
{
    use HasFactory;
    protected $fillable=[
        'etablissement_id',
        'indicateur_id',
        'valeurAtteinte',
        'observation',
        'valide',
    ];
    /**
     * Get all of the etablissements for the Indicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    /**
     * Get all of the indicateurs for the SuiviIndicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indicateur()
    {
        return $this->belongsTo(Indicateur::class, 'indicateur_id');
    }
}
