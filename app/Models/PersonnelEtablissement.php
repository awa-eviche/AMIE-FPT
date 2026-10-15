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
        'specialite',
        'interne',
        'user_id',
        'etablissement_id',
        'date_debut',      // ← ajout
        'date_fin',        // ← ajout
        'actif', 
    ];
 protected $casts = [
        'interne' => 'boolean',
        'actif' => 'boolean',       // ← ajout
    'date_debut' => 'date',     // ← ajout
    'date_fin' => 'date',       // ← ajout
    ];
  
// Scope : uniquement les séjours en cours
public function scopeActif($query)
{
    return $query->where('actif', true);
}

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    public function user()
    {
       return $this->belongsTo(User::class); 
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
