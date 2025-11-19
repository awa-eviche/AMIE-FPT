<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    use HasFactory;

    public function listeable()
    {
        return $this->morphTo();
    }

    protected $fillable = [
        "libelle",
        "valeur",
        "description",
        "isDeleted",
    ];

}
