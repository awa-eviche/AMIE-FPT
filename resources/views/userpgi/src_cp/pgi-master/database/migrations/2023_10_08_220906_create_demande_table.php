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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle")->nullable();
            $table->date("date_depot");
            $table->date("date_expiration");

            $table->unsignedBigInteger('demande_parente_id')->nullable();
            $table->foreign('demande_parente_id')->references('id')->on('demandes');

            $table->unsignedBigInteger('etat_id')->nullable();
            $table->foreign('etat_id')->references('id')->on('etat_workflows');

            $table->unsignedBigInteger('accorded_agent_id')->nullable();
            $table->foreign('accorded_agent_id')->references('id')->on('agents');

            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->foreign('entreprise_id')->references('id')->on('entreprises');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
