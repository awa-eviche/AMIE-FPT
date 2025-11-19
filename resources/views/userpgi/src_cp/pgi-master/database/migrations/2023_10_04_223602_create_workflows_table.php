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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('libelle')->nullable();
            $table->string('description')->nullable();
            $table->boolean('estActif')->default(true);

            $table->unsignedBigInteger('type_demande_id');
            $table->foreign('type_demande_id')->references('id')->on('type_demandes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
