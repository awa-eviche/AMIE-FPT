<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DroitInscription extends Model
{
    use HasFactory;

    protected $table = 'droit_inscription'; 

    protected $fillable = [
        'inscription_id',
        'montant',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
