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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');


            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('canal_notification')->nullable();

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles'); 

            $table->unsignedBigInteger('userable_id')->nullable();
            $table->string('userable_type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('date_naissance');
            $table->dropColumn('lieu_naissance');
            $table->dropColumn('adresse');
            $table->dropColumn('telephone');
            $table->dropColumn('canal_notification');

            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

    }
};
