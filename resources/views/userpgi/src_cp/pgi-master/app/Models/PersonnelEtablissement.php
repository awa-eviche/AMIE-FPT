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
        return $this->hasOne(User::class);
    }


    
}
