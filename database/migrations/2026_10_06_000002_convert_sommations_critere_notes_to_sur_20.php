<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Les notes des critères (évaluation sommative APC) étaient saisies en pourcentage (0 à 100) ;
 * elles le sont désormais sur 20, comme celles des disciplines.
 *
 * Données existantes : note / 5 (80 % => 16/20). Les décisions Acquis / Non acquis ne changent pas,
 * puisque le seuil de réussite reste exprimé en pourcentage et que la note lui est comparée x5.
 * Les notes des disciplines (ressource_id renseigné) étaient déjà sur 20 : elles ne sont pas touchées.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('sommations')->whereNotNull('critere_id')->whereNotNull('note')
            ->update(['note' => DB::raw('ROUND(note / 5, 2)')]);
    }

    public function down(): void
    {
        DB::table('sommations')->whereNotNull('critere_id')->whereNotNull('note')
            ->update(['note' => DB::raw('LEAST(ROUND(note * 5, 2), 100)')]);
    }
};
