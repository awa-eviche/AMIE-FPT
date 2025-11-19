<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public $timestamps = false;
    protected $fillable = [
        'code',
        'libelle',
        'isDeleted',
        'region_id',
    ];
}
