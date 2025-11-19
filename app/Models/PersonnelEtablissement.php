<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelEtablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'fonction',
        'dernierDiplomeAcademique',
        'dernierDiplomeProfessionnel',
        'interne',
        'user_id',
        'etablissement_id'
    ];


    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    public function user()
    {
       return $this->belongsTo(User::class); // Un PersonnelEtablissement appartient à un seul utilisateur
    }

 public function classes()
{
    return $this->belongsToMany(
        \App\Models\Classe::class,
        'formateur_etablissement',
        'personnel_etablissement_id',
        'classe_id'
    )
    ->withPivot('role')
    ->withTimestamps();
}
    
}
