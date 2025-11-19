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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('type_demande')->nullable();
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->foreign('etablissement_id')->references('id')->on('etablissements'); 
            $table->unsignedBigInteger('filiere_id')->nullable();
            $table->foreign('filiere_id')->references('id')->on('filieres'); 
            $table->unsignedBigInteger('niveau_etude_id')->nullable();
            $table->foreign('niveau_etude_id')->references('id')->on('niveau_etudes'); 
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
