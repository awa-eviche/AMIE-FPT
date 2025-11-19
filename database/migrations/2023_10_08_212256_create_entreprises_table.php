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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();

            $table->string('nom_entreprise');
            $table->string('ninea');
            $table->integer('effectif');
            $table->string('email_entreprise');
            $table->boolean('est_actif')->default(true);
            $table->date('date_creation');
            $table->integer('user_id')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
