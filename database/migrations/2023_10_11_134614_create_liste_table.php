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
        Schema::create('listes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->string("valeur");
            $table->text("description")->nullable();

            $table->unsignedBigInteger('listeable_id')->nullable();
            $table->string('listeable_type')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liste');
    }
};
