<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Rattache les notes à une année académique (comme pour les devoirs et les
 * affectations) : évaluations PPO, compositions APC (evalutes) et sommations APC.
 * Toutes les notes déjà en base sont de l'année 2025-2026, sauf celles des inscriptions d'une année
 * plus récente (déjà saisies pour 2026-2027) qui prennent l'année de leur inscription.
 */
return new class extends Migration
{
    private const TABLES = ['evaluations', 'evalutes', 'sommations'];

    public function up(): void
    {
        // On s'arrête AVANT toute modification si l'année de rattachement n'existe pas :
        // sinon les notes resteraient sans année et disparaîtraient des écrans filtrés par année.
        $anneeId = DB::table('annee_academiques')->where('code', '2025-2026')->value('id')
            ?? DB::table('annee_academiques')->where('annee1', 2025)->where('annee2', 2026)->value('id');

        if (!$anneeId) {
            throw new RuntimeException("L'année académique 2025-2026 est introuvable dans annee_academiques : "
                . "créez-la avant de lancer cette migration (les notes existantes lui sont rattachées).");
        }

        foreach (self::TABLES as $table) {
            if (!Schema::hasColumn($table, 'annee_academique_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->foreignId('annee_academique_id')->nullable()
                        ->constrained('annee_academiques')->nullOnDelete();
                });
            }
        }

        foreach (self::TABLES as $table) {
            DB::table($table)->whereNull('annee_academique_id')->update(['annee_academique_id' => $anneeId]);

            // Notes déjà saisies pour une année plus récente (ex. 2026-2027) : année de leur inscription.
            DB::update("UPDATE $table n
                JOIN inscriptions i ON i.id = n.inscription_id
                JOIN annee_academiques a ON a.id = i.annee_academique_id
                SET n.annee_academique_id = i.annee_academique_id
                WHERE CAST(a.annee1 AS UNSIGNED) > (SELECT CAST(annee1 AS UNSIGNED) FROM annee_academiques WHERE id = ?)", [$anneeId]);

            if (DB::table($table)->whereNull('annee_academique_id')->exists()) {
                throw new RuntimeException("Des lignes de « $table » sont restées sans année académique après le rattrapage.");
            }
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            if (!Schema::hasColumn($table, 'annee_academique_id')) {
                continue;
            }
            // Les tables MyISAM (devoirapc, sommations) n'ont pas de clé étrangère à supprimer.
            $cle = "{$table}_annee_academique_id_foreign";
            $aUneCle = DB::table('information_schema.table_constraints')
                ->where('table_schema', DB::raw('DATABASE()'))->where('table_name', $table)
                ->where('constraint_name', $cle)->exists();

            Schema::table($table, function (Blueprint $t) use ($aUneCle, $cle) {
                if ($aUneCle) {
                    $t->dropForeign($cle);
                }
                $t->dropColumn('annee_academique_id');
            });
        }
    }
};
