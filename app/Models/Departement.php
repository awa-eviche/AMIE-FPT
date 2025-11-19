<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class Departement extends Model
{
    use HasFactory;

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function communes()
    {
        return $this->hasMany(Commune::class, 'commune_id');
    }
    public function ias()
    {   
        return $this->belongsToMany(Ia::class, 'departement_ias', 'ia_id', 'departement_id');
    }
   public function etablissements(): HasManyThrough
    {
        return $this->hasManyThrough(
            Etablissement::class,
            Commune::class,
            'departement_id', // clé étrangère sur la table `communes`
            'commune_id',     // clé étrangère sur la table `etablissements`
            'id',             // clé locale sur la table `departements`
            'id'              // clé locale sur la table `communes`
        );
    }

    public $timestamps = false;
    protected $fillable = [
        'code',
        'libelle',
        'isDeleted',
        'region_id',
    ];
}
