<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demandeur extends Model
{
    use HasFactory;

 

    public $timestamps = false;
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'email',
       
    ];
}
