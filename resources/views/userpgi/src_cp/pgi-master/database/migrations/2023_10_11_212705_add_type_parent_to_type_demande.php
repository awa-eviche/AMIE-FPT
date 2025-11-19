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
        Schema::table('type_demandes', function (Blueprint $table) {
            $table->unsignedBigInteger('type_demande_id')->nullable();
            $table->foreign('type_demande_id')->references('id')->on('type_demandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_demandes', function (Blueprint $table) {


        });
    }
};
