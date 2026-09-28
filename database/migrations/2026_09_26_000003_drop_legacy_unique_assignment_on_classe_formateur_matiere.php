<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Supprime l'ancien index d'unicité (classe, formateur, matière) de classe_formateur_matiere.
 *
 * Il ne tient compte ni de l'année ni du semestre : il empêchait de réaffecter la même
 * matière au même formateur dans la même classe pour une nouvelle année académique, ou
 * pour le second semestre. L'unicité reste garantie par cfm_unique_par_annee_semestre
 * (classe, formateur, matière, année, semestre).
 */
return new class extends Migration
{
    private const TABLE = 'classe_formateur_matiere';
    private const ANCIEN = 'unique_assignment';
    private const ACTUEL = 'cfm_unique_par_annee_semestre';

    private function indexExiste(string $nom): bool
    {
        return DB::table('information_schema.statistics')
            ->where('table_schema', DB::raw('DATABASE()'))
            ->where('table_name', self::TABLE)
            ->where('index_name', $nom)
            ->exists();
    }

    public function up(): void
    {
        // Ne pas supprimer l'ancienne garantie sans être sûr que la nouvelle existe.
        if (!$this->indexExiste(self::ACTUEL)) {
            throw new RuntimeException("L'index " . self::ACTUEL . " est absent de " . self::TABLE
                . " : lancez d'abord les migrations d'affectation par année/semestre.");
        }

        if ($this->indexExiste(self::ANCIEN)) {
            Schema::table(self::TABLE, function (Blueprint $t) {
                $t->dropUnique(self::ANCIEN);
            });
        }
    }

    public function down(): void
    {
        // Recréé seulement si aucune ligne ne le viole (des affectations d'années ou de
        // semestres différents peuvent désormais coexister).
        $doublons = DB::table(self::TABLE)->select('classe_id', 'formateur_id', 'matiere_id')
            ->groupBy('classe_id', 'formateur_id', 'matiere_id')->havingRaw('COUNT(*) > 1')->exists();

        if (!$doublons && !$this->indexExiste(self::ANCIEN)) {
            Schema::table(self::TABLE, function (Blueprint $t) {
                $t->unique(['classe_id', 'formateur_id', 'matiere_id'], self::ANCIEN);
            });
        }
    }
};
