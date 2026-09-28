<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('creneaux_emploi_du_temps', function (Blueprint $table) {
            $table->foreignId('ressource_id')->nullable()->after('matiere_id')
                ->constrained('ressources')->nullOnDelete();
            $table->foreignId('competence_id')->nullable()->after('ressource_id')
                ->constrained('competences')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('creneaux_emploi_du_temps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ressource_id');
            $table->dropConstrainedForeignId('competence_id');
        });
    }
};
