<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->dropUnique('cfm_unique_par_annee');
            $table->unsignedTinyInteger('semestre')->nullable()->after('matiere_id');
        });

        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->unique(
                ['classe_id', 'formateur_id', 'matiere_id', 'annee_academique_id', 'semestre'],
                'cfm_unique_par_annee_semestre'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->dropUnique('cfm_unique_par_annee_semestre');
            $table->dropColumn('semestre');
        });

        Schema::table('classe_formateur_matiere', function (Blueprint $table) {
            $table->unique(['classe_id', 'formateur_id', 'matiere_id', 'annee_academique_id'], 'cfm_unique_par_annee');
        });
    }
};
