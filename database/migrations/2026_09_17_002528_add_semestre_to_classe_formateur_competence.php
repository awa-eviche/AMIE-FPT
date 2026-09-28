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
        Schema::table('classe_formateur_competence', function (Blueprint $table) {
            $table->unsignedTinyInteger('semestre')->nullable()->after('competence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classe_formateur_competence', function (Blueprint $table) {
            $table->dropColumn('semestre');
        });
    }
};
