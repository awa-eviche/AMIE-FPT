<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Territoire;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Efpt extends Model
{
    use HasFactory;


    protected $fillable = [
        "id",
      
        "tel",
        "nom",
        "adresse",
        "territoire_id",
    ];

    public function departement()
	{
	return $this->belongsTo(Territoire::class);
	}
    public function programms()
    {
        return $this->hasMany(Programms::class);
    }
    public function filieresEtNiveaux()
{
    return $this->hasManyThrough(
        Branche::class,
        Programms::class,
        'etablissement_id',
        'id',
        'id',
        'programme_id'
    )->distinct();
}

   
}
