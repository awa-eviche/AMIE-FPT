<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function departement()
    {
        return $this->hasMany(Departement::class, 'departement_id');
    }

    public $timestamps = false;
    protected $fillable = [
        'code',
        'libelle',
        'isDeleted',
    ];
}
