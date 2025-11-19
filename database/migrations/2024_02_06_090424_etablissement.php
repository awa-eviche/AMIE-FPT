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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('sigle')->nullable();
            $table->string('nom')->nullable();
            $table->string('logo')->nullable();
            $table->string('adresse')->nullable();
            $table->string('slogan')->nullable();
            $table->string('siteWeb')->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('statut')->nullable();
            $table->string('statutJuridique')->nullable();
            $table->string('type')->nullable();
            $table->string('boitePostale')->nullable();
            $table->date('dateCreation')->nullable();
            $table->string('reference')->nullable();
            $table->string('nomResponsable')->nullable();
            $table->string('prenomResponsable')->nullable();
            $table->string('numRecipisse')->nullable();
            $table->date('dateRecepisseDepot')->nullable();
            $table->string('numAutOuv')->nullable();
            $table->string('dateAutOuv')->nullable();
            $table->string('specifite')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('isDeleted')->default(false);
            $table->foreignId('commune_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
