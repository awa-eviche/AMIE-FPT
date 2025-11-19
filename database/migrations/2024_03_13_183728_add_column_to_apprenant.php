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
        Schema::table('apprenants', function (Blueprint $table) {
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apprenant', function (Blueprint $table) {
            //
        });
    }
};
