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
        Schema::create('annee_academiques', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable();
            $table->string("annee1")->nullable();
            $table->string("annee2")->nullable();
            $table->date("dateDebut")->nullable();
            $table->date("dateFin")->nullable();
            $table->boolean("is_open")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annee_academique');
    }
};
