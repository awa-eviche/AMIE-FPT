<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Classe des notes dont l'inscription n'existe plus (ou dont l'apprenant est supprimé).
 *
 * Les évaluations n'ont ni classe ni année propre : on les rattache à la classe de leur
 * inscription. Quand cette inscription n'existe plus (données historiques ou restaurées
 * partiellement), on retient la classe portée par les devoirs du même apprenant. Sur une
 * base cohérente il n'y a aucune note orpheline : la correspondance est alors vide et
 * tout le calcul reste en SQL.
 */
class InscriptionClasses
{
    /** @var array<int, int>|null */
    private static ?array $orphelines = null;

    /**
     * Sous-requête : inscriptions valides (apprenant non supprimé) portant l'identifiant.
     *
     * @param string $colonne colonne de la requête parente contenant l'inscription_id
     */
    public static function valide(string $colonne): \Closure
    {
        return fn ($q) => $q->select(DB::raw(1))->from('inscriptions as iv')
            ->join('apprenants as av', 'av.id', '=', 'iv.apprenant_id')
            ->whereColumn('iv.id', $colonne)->where('av.isDeleted', 0);
    }

    /** @return array<int, int> inscription_id (sans inscription valide) => classe_id d'après les devoirs */
    public static function orphelines(): array
    {
        return self::$orphelines ??= DB::table('devoirs as d')
            ->whereNotExists(self::valide('d.inscription_id'))
            ->select('d.inscription_id', DB::raw('MIN(d.classe_id) as classe_id'))
            ->groupBy('d.inscription_id')
            ->pluck('classe_id', 'inscription_id')->all();
    }

    /** Pour les tests et les appels successifs dans un même processus. */
    public static function reset(): void
    {
        self::$orphelines = null;
    }
}
