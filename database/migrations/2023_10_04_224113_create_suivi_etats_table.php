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
        Schema::create('suivi_etats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etat_workflow_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('est_rejete')->nullable();
            $table->string('motif_rejet')->nullable();
            $table->dateTime('date_entree');
            $table->dateTime('date_sortie')->nullable();
            $table->integer('id_entite');
            $table->string('nom_entite');
            $table->timestamps();

            $table->foreign('etat_workflow_id')->references('id')->on('etat_workflows');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivi_etats');
    }
};
