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
        Schema::create('permission_etat_roles', function (Blueprint $table) {
            $table->id();

            // $table->string('nom')->nullable();
            // $table->string('code')->nullable();
            // $table->string('description')->nullable();
            // $table->boolean('est_actif')->default(true);

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->unsignedBigInteger('etat_workflow_id');
            $table->foreign('etat_workflow_id')->references('id')->on('etat_workflows');


            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_etat_profils');
    }
};
