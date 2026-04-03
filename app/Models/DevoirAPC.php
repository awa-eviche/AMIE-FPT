<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevoirAPC extends Model
{
    protected $table = 'devoirAPC';

    protected $fillable = [
        'libelle',
        'note',
        'mcc',
        'ressource_id',
        'inscription_id',
        'semestre',
    ];

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }
     public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
