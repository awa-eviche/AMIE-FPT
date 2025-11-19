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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')->constrained()->nullable();
            $table->foreignId('matiere_id')->constrained()->nullable();
            $table->decimal('note_cc', 8, 2)->nullable(); // Note pour les contrôles continus du semestre 1
            $table->decimal('note_composition', 8, 2)->nullable(); // Note pour la composition du semestre 1
            $table->string('semestre')->nullable();
            $table->string('appreciation')->nullable();
           
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
