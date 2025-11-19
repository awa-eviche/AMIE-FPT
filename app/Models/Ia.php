<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Ia extends Model
{
    use HasFactory;


    public $timestamps = false;
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
        'isDeleted',  
    ];

    public function departements()
    {
        return $this->belongsToMany(Departement::class, 'departement_ias', 'ia_id', 'departement_id');
    }

    public function syncDepartements(array $departementIds)
    {
        $this->departements()->sync($departementIds);
    }
}
