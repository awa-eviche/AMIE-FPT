<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'date_absence',
        'semestre',
        'heure_debut',
        'heure_fin',
        'duree',
        'retard',
        'minutes_retard',
        'motif',
        'type',
        'justifie',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
