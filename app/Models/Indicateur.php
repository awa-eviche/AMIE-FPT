<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Indicateur extends Model
{
    use HasFactory;
    protected $fillable=[
        'typeIndicateur_id',
        'anneeAcademique_id',
        'cible',
        'public',
        'label',
        'date_echeance',
    ];

    /**
     * Get all of the typeIndicateurs for the Indicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function typeIndicateur()
    {
        return $this->belongsTo(TypeIndicateur::class,'typeIndicateur_id');
    }

    /**
     * Get all of the anneeacademiques for the Indicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function anneeacademique()
    {
        return $this->belongsTo(AnneeAcademique::class, 'anneeAcademique_id');
    }

    /**
     * Get the suiviIndicateur that owns the Indicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function suiviIndicateur()
    {
        return $this->hasMany(SuiviIndicateur::class, 'indicateur_id');
    }
    
}
