<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public $timestamps = false;
    protected $fillable = [
        'code',
        'libelle',
        'isDeleted',
        'departement_id',
       
    ];
}
