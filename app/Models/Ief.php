<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ief extends Model
{
    use HasFactory;


    public function ia()
    {
        return $this->belongsTo(Ia::class, 'ia_id');
    }

  
    public $timestamps = false;
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
        'isDeleted',
        'ia_id',
    ];


    public function communes()
    {
        return $this->belongsToMany(Commune::class, 'commune_iefs', 'ief_id', 'commune_id');
    }

    public function syncCommunes(array $communeIds)
    {
        $this->communes()->sync($communeIds);
    }
}
