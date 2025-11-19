<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Efpt;
class Territoire extends Model
{
    use HasFactory;


    protected $fillable = [
        "id",
        "nom_depart",
       
    ];

    public function efpts()
    {
        return $this->hasMany(Efpt::class);
    }

   
}
