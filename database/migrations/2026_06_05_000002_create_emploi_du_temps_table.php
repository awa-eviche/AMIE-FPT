<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emploi_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('etablissement_id')->constrained('etablissements');
            $table->foreignId('annee_academique_id')->constrained('annee_academiques');
            $table->string('type_planning'); // 'hebdomadaire' | 'semestriel'
            $table->unsignedTinyInteger('semaine')->nullable(); // numéro semaine ISO (1-53)
            $table->unsignedTinyInteger('semestre')->nullable(); // 1 ou 2
            $table->string('statut')->default('brouillon'); // 'brouillon' | 'publié'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emploi_du_temps');
    }
};
