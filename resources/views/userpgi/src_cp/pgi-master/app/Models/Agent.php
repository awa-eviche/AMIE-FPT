<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Agent extends Model
{
    use HasFactory;

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'accorded_agent_id');
    }


    protected $fillable = [
        "estMembreComite",
        "user_id"
    ];
}
