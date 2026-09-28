<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux_emploi_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emploi_du_temps_id')->constrained('emploi_du_temps')->cascadeOnDelete();
            $table->foreignId('personnel_etablissement_id')->constrained('personnel_etablissements');
            $table->string('jour'); // lundi, mardi, mercredi, jeudi, vendredi, samedi
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('salle')->nullable();
            // PPO : matiere_id, APC : element_competence_id
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->nullOnDelete();
            $table->foreignId('element_competence_id')->nullable()->constrained('element_competences')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux_emploi_du_temps');
    }
};
