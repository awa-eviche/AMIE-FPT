<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $connection = 'sigep'; // Connexion vers la base de :8000
    protected $table = 'assets';

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
}
