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
        Schema::create('history_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->string('old_note_cc')->nullable();
            $table->string('old_note_composition')->nullable();
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
