<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Rend à leur classe d'origine les apprenants APC réinscrits avant la correction de la
 * réinscription : leur inscription était déplacée vers la nouvelle classe et la nouvelle année,
 * ils n'apparaissaient donc plus dans la classe de l'année antérieure.
 *
 * La classe et l'année d'origine sont celles de leurs devoirs APC. On ajoute seulement
 * l'inscription manquante : les devoirs, évaluations et l'inscription actuelle ne sont pas modifiés.
 */
return new class extends Migration
{
    public function up(): void
    {
        $origines = DB::table('devoirapc as d')
            ->join('inscriptions as i', 'i.id', '=', 'd.inscription_id')
            ->join('ressources as r', 'r.id', '=', 'd.ressource_id')
            ->join('classes as c', 'c.id', '=', 'r.classe_id')
            ->join('annee_academiques as an', 'an.id', '=', 'd.annee_academique_id')
            ->join('annee_academiques as ai', 'ai.id', '=', 'i.annee_academique_id')
            ->whereColumn('an.code', '<', 'ai.code')
            ->whereColumn('r.classe_id', '<>', 'i.classe_id')
            ->whereNotExists(fn ($q) => $q->select(DB::raw(1))->from('inscriptions as p')
                ->whereColumn('p.apprenant_id', 'i.apprenant_id')
                ->whereColumn('p.annee_academique_id', 'd.annee_academique_id'))
            ->groupBy('i.apprenant_id', 'd.annee_academique_id')
            // Origine ambiguë (devoirs dans plusieurs classes la même année) : on ne devine pas.
            ->havingRaw('COUNT(DISTINCT r.classe_id) = 1')
            ->select('i.apprenant_id', 'd.annee_academique_id',
                DB::raw('MIN(r.classe_id) as classe_id'), DB::raw('MIN(i.dateInscription) as dateInscription'))
            ->get();

        foreach ($origines as $o) {
            DB::table('inscriptions')->insert([
                'apprenant_id' => $o->apprenant_id,
                'classe_id' => $o->classe_id,
                'annee_academique_id' => $o->annee_academique_id,
                'statut' => 'actif',
                'redoublant' => 0,
                'dateInscription' => $o->dateInscription,
            ]);
        }
    }

    public function down(): void
    {
        // Les inscriptions rétablies ne se distinguent plus des autres : rien à annuler.
    }
};
