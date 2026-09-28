<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'nombre_heure_absence',
        'nombre_heure_retard',
        'semestre',
        'type',
        'justifie',
        'nonjustifie',
        'annee_academique_id',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
