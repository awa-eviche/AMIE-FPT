<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    protected $fillable = [
        'inscription_id',
        'matiere_id',
        'libelle',
        'note',
        'semestre',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }


    public static function moyenneCC($inscriptionId, $matiereId, $semestre)
{
    return self::where([
        'inscription_id' => $inscriptionId,
        'matiere_id'     => $matiereId,
        'semestre'       => $semestre,
    ])->avg('note') ?? 0;
}

}