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
        Schema::table('projets', function (Blueprint $table) {
            $table->unsignedBigInteger('annee_academique_id')->nullable();
            $table->foreign('annee_academique_id')->references('id')->on('annee_academiques');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('ancienne_denomination_etablissement')->nullable();
            $table->string('nouvelle_denomination_etablissement')->nullable();
            $table->string('ancienne_adresse_etablissement')->nullable();
            $table->string('nouvelle_adresse_etablissement')->nullable();
            $table->json('aire')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
