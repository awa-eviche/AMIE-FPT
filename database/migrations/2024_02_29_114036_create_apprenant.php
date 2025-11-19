<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\MarriageStatus;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->string("nomTuteur")->nullable();
            $table->string("prenomTuteur")->nullable();
            $table->string("numTelTuteur")->nullable();
            $table->enum('situationMatrimoniale', [MarriageStatus::SINGLE, MarriageStatus::MARRIED, MarriageStatus::DIVORCED, MarriageStatus::WIDOWED])->nullable();
            $table->string("prenomPere")->nullable();
            $table->string("nomPere")->nullable();
            $table->string("prenomMere")->nullable();
            $table->string("nomMere")->nullable();
            $table->date("dateInsertion")->nullable();
            $table->boolean("autoEmploi")->nullable();
            $table->boolean("emploiSalarie")->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->foreignId('user_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenants');
    }
};
