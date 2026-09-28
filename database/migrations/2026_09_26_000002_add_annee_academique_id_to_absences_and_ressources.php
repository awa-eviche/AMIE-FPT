<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Rattache les absences et les ressources (disciplines APC) à une année académique,
 * comme les devoirs, les notes et les affectations des formateurs.
 *
 * Données existantes :
 *  - absences : année de l'inscription concernée ;
 *  - ressources : année de leurs devoirs quand elles en ont (source la plus fiable) ;
 *    sinon 2025-2026 si créées jusqu'à la fin de cette année, 2026-2027 ensuite
 *    (même règle que les affectations créées depuis septembre).
 */
return new class extends Migration
{
    public function up(): void
    {
        $ancienne = DB::table('annee_academiques')->where('code', '2025-2026')->first();
        if (!$ancienne) {
            throw new RuntimeException("L'année académique 2025-2026 est introuvable dans annee_academiques : "
                . "créez-la avant de lancer cette migration.");
        }
        $nouvelle = DB::table('annee_academiques')->where('code', '2026-2027')->first();
        $ancienneId = $ancienne->id;
        $nouvelleId = $nouvelle->id ?? $ancienneId;

        foreach (['absences', 'ressources'] as $table) {
            if (!Schema::hasColumn($table, 'annee_academique_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->foreignId('annee_academique_id')->nullable()
                        ->constrained('annee_academiques')->nullOnDelete();
                });
            }
        }

        // Absences : année de l'inscription ; à défaut (inscription supprimée), 2025-2026.
        DB::statement('UPDATE absences a JOIN inscriptions i ON i.id = a.inscription_id
            SET a.annee_academique_id = i.annee_academique_id
            WHERE a.annee_academique_id IS NULL AND i.annee_academique_id IS NOT NULL');
        DB::table('absences')->whereNull('annee_academique_id')->update(['annee_academique_id' => $ancienneId]);

        // Ressources : 1) année de leurs devoirs APC ; 2) à défaut, date de création.
        DB::statement('UPDATE ressources r JOIN (
                SELECT ressource_id, MIN(annee_academique_id) AS annee FROM devoirapc
                WHERE annee_academique_id IS NOT NULL GROUP BY ressource_id
            ) d ON d.ressource_id = r.id
            SET r.annee_academique_id = d.annee WHERE r.annee_academique_id IS NULL');

        $fin = ($ancienne->dateFin ?? '2026-07-31') . ' 23:59:59';
        DB::table('ressources')->whereNull('annee_academique_id')->where('created_at', '<=', $fin)
            ->update(['annee_academique_id' => $ancienneId]);
        DB::table('ressources')->whereNull('annee_academique_id')
            ->update(['annee_academique_id' => $nouvelleId]);

        foreach (['absences', 'ressources'] as $table) {
            if (DB::table($table)->whereNull('annee_academique_id')->exists()) {
                throw new RuntimeException("Des lignes de « $table » sont restées sans année académique après le rattrapage.");
            }
        }
    }

    public function down(): void
    {
        foreach (['absences', 'ressources'] as $table) {
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
