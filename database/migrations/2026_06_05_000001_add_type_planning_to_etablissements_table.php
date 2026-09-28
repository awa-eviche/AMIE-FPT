<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->string('type_planning')->default('hebdomadaire')->after('approved');
        });
    }

    public function down(): void
    {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->dropColumn('type_planning');
        });
    }
};
