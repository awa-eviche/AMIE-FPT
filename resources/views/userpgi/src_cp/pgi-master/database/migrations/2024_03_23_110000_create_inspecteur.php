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
        Schema::create('inspecteurs', function (Blueprint $table) {
            $table->id();
            $table->boolean("chefInspection")->default(false);
            $table->string("specialite")->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->foreignId('ia_id')->constrained()->nullable();
            $table->foreignId('ief_id')->constrained()->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecteur');
    }
};
