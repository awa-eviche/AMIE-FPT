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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle")->nullable();
            $table->string("modalite")->nullable();
            $table->foreignId('etablissement_id')->constrained()->nullable();
            $table->foreignId('niveau_etude_id')->constrained()->nullable();
            $table->foreignId('annee_academique_id')->constrained()->nullable();
            
            $table->string("statut")->default('en attente');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe');
    }
};
