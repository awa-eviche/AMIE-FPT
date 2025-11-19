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
        Schema::create('log_users', function (Blueprint $table) {
            $table->id();
            $table->string('action', 50);
            $table->string('description')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->string('model', 50)->nullable();
            $table->json('old_object')->nullable();
            $table->json('new_object')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_users');
    }
};
