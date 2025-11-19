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
        Schema::create('etat_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('type_notification_id')->nullable();
            $table->unsignedBigInteger('etat_suivant_id')->nullable();
            $table->unsignedBigInteger('etat_rejet_id')->nullable();
            $table->integer('position');
            $table->string('code');
            $table->string('libelle')->nullable();
            $table->string('description')->nullable();
            $table->string('bouton_suivant')->nullable();
            $table->string('bouton_rejet')->nullable();
            $table->boolean('est_rejetable')->nullable();
            $table->string('libelle_rejet')->nullable();
            $table->boolean('est_fin')->nullable();
            $table->timestamps();
            $table->foreign('workflow_id')->references('id')->on('workflows');
            $table->foreign('etat_suivant_id')->references('id')->on('etat_workflows');
            $table->foreign('etat_rejet_id')->references('id')->on('etat_workflows');
            $table->foreign('type_notification_id')->references('id')->on('type_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etat_workflows');
    }
};
