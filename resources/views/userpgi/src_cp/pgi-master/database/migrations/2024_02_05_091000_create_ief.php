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
        Schema::create('iefs', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("telephone")->nullable();
            $table->string("adresse")->nullable();
            $table->string("email")->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->foreignId('ia_id')->constrained()->nullable();
            // $table->foreignId('commune_id')->constrained()->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ief');
    }
};
