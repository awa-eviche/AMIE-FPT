<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->foreignId('annee_academique_id')->nullable()->after('classe_id')
                ->constrained('annee_academiques')->nullOnDelete();
        });

        Schema::table('classe_formateur_competence', function (Blueprint $table) {
            $table->foreignId('annee_academique_id')->nullable()->after('classe_id')
                ->constrained('annee_academiques')->nullOnDelete();
        });

        $anneeId = DB::table('annee_academiques')->where('code', '2025-2026')->value('id');

        if ($anneeId) {
            DB::table('classe_formateur_matiere')->whereNull('annee_academique_id')->update(['annee_academique_id' => $anneeId]);
            DB::table('classe_formateur_competence')->whereNull('annee_academique_id')->update(['annee_academique_id' => $anneeId]);
        }

        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->unique(['classe_id', 'formateur_id', 'matiere_id', 'annee_academique_id'], 'cfm_unique_par_annee');
        });
    }

    public function down(): void
    {
        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->dropUnique('cfm_unique_par_annee');
            $table->dropConstrainedForeignId('annee_academique_id');
        });

        Schema::table('classe_formateur_competence', function (Blueprint $table) {
            $table->dropConstrainedForeignId('annee_academique_id');
        });
    }
};
