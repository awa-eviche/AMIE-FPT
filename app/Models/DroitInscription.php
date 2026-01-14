<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DroitInscription extends Model
{
    use HasFactory;

    protected $table = 'droit_inscription'; // important si nom non pluriel

    protected $fillable = [
        'inscription_id',
        'montant',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    /**
     * Relation : un droit d’inscription appartient à une inscription
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
