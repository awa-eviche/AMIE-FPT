<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Marque les inscriptions des redoublants : l'apprenant reste dans la même classe,
 * garde son inscription de l'année précédente et en reçoit une nouvelle pour l'année suivante.
 *
 * Données existantes : est redoublante toute inscription précédée, pour le même apprenant
 * et la même classe, d'une inscription sur une année académique antérieure.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('inscriptions', 'redoublant')) {
            Schema::table('inscriptions', function (Blueprint $t) {
                $t->boolean('redoublant')->default(false)->after('statut');
            });
        }

        DB::statement('UPDATE inscriptions i
            JOIN annee_academiques a ON a.id = i.annee_academique_id
            JOIN inscriptions p ON p.apprenant_id = i.apprenant_id AND p.classe_id = i.classe_id AND p.id <> i.id
            JOIN annee_academiques pa ON pa.id = p.annee_academique_id AND pa.code < a.code
            SET i.redoublant = 1');
    }

    public function down(): void
    {
        if (Schema::hasColumn('inscriptions', 'redoublant')) {
            Schema::table('inscriptions', function (Blueprint $t) {
                $t->dropColumn('redoublant');
            });
        }
    }
};
