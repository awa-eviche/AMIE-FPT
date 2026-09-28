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
        'mcc',
        'classe_id',
        'annee_academique_id',
    ];

    /** Filet de sécurité : un devoir n'est jamais enregistré sans année académique (année choisie, sinon 2025-2026). */
    protected static function booted(): void
    {
        static::creating(function (self $devoir) {
            if (! $devoir->annee_academique_id && \App\Services\AnneeDesNotes::aUneColonne('devoirs')) {
                $devoir->annee_academique_id = \App\Services\AnneeDesNotes::choisie();
            }
        });
    }

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