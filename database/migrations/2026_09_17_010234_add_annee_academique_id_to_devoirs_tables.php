<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('devoirs', function (Blueprint $table) {
            $table->foreignId('annee_academique_id')->nullable()->after('classe_id')
                ->constrained('annee_academiques')->nullOnDelete();
        });

        Schema::table('devoirapc', function (Blueprint $table) {
            $table->foreignId('annee_academique_id')->nullable()->after('ressource_id')
                ->constrained('annee_academiques')->nullOnDelete();
        });

        $anneeId = DB::table('annee_academiques')->where('code', '2025-2026')->value('id')
            ?? DB::table('annee_academiques')->where('annee1', 2025)->where('annee2', 2026)->value('id');

        if ($anneeId) {
            DB::table('devoirs')->whereNull('annee_academique_id')->update(['annee_academique_id' => $anneeId]);
            DB::table('devoirapc')->whereNull('annee_academique_id')->update(['annee_academique_id' => $anneeId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devoirs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('annee_academique_id');
        });

        Schema::table('devoirapc', function (Blueprint $table) {
            $table->dropConstrainedForeignId('annee_academique_id');
        });
    }
};
