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
        Schema::create('personnel_etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('fonction')->nullable();
            $table->string('dernierDiplomeAcademique')->nullable();
            $table->string('dernierDiplomeProfessionnel')->nullable();
            $table->boolean('interne')->nullable();
            $table->foreignId('etablissement_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
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
