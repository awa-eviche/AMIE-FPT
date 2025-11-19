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
        Schema::table('suivi_etats', function (Blueprint $table) {
            $table->unsignedBigInteger('suivi_etatable_id');
            $table->string('suivi_etatable_type');
            $table->dropColumn('nom_entite');
            $table->dropColumn('id_entite');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etat_workflows', function (Blueprint $table) {
            $table->dropColumn('suivi_etatable_id');
            $table->dropColumn('suivi_etatable_type');
            $table->string('nom_entite');
            $table->string('id_entite');

        });

    }
};
