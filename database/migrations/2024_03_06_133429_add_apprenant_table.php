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
            $table->dropConstrainedForeignId('user_id');


            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->unique();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apprenants', function (Blueprint $table) {
            
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('date_naissance');
            $table->dropColumn('lieu_naissance');
            $table->dropColumn('adresse');
            $table->dropColumn('telephone');
            $table->dropColumn('email');
            
        });
    }
};
