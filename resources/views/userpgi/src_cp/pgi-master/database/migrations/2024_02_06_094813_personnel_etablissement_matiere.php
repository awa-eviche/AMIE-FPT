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
        Schema::create('personnel_etablissement_matiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_etablissement_id')->nullable();
            $table->unsignedBigInteger('matiere_id')->nullable();
            $table->unsignedBigInteger('etablissement_id')->nullable();
    
            $table->foreign('personnel_etablissement_id','fk_personnel_eta_id')->references('id')->on('personnel_etablissements')->onDelete('cascade');
            $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade');
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade');
            $table->timestamps();
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
