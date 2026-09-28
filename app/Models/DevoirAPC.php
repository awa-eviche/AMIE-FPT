<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevoirAPC extends Model
{
    protected $table = 'devoirapc';

    protected $fillable = [
        'libelle',
        'note',
        'mcc',
        'ressource_id',
        'inscription_id',
        'semestre',
        'annee_academique_id',
    ];

    /**
     * Filet de sécurité : un devoir APC n'est jamais enregistré sans année académique.
     * Année de sa ressource, à défaut l'année choisie / 2025-2026 (tant que 2026-2027 n'est pas choisie).
     */
    protected static function booted(): void
    {
        static::creating(function (self $devoir) {
            if ($devoir->annee_academique_id || ! \App\Services\AnneeDesNotes::aUneColonne('devoirapc')) {
                return;
            }
            $devoir->annee_academique_id = ($devoir->ressource_id
                    ? Ressource::whereKey($devoir->ressource_id)->value('annee_academique_id')
                    : null)
                ?: \App\Services\AnneeDesNotes::choisie();
        });
    }

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }
     public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}
