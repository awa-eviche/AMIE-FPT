<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Les colonnes de notes avaient des types sans décimales (créées hors migrations) :
 * devoirs.note INT, evaluations.note_cc / note_composition DECIMAL(10,0), evalutes.composition TINYINT(1).
 * Une note de 12,5 était enregistrée 13. On passe toutes les notes en DECIMAL(5,2) (0,00 à 20,00).
 * Les valeurs existantes sont conservées telles quelles (élargissement de précision uniquement).
 */
return new class extends Migration
{
    /** table => [colonne => nullable] */
    private array $colonnes = [
        'devoirs'     => ['note' => false, 'mcc' => true],
        'devoirapc'   => ['note' => true, 'mcc' => true],
        'evaluations' => ['note_cc' => true, 'note_composition' => true],
        'evalutes'    => ['composition' => true],
    ];

    /** Anciens types, pour le retour arrière. */
    private array $anciens = [
        'devoirs'     => ['note' => 'INT NOT NULL', 'mcc' => 'VARCHAR(255) NULL'],
        'devoirapc'   => ['note' => 'DECIMAL(5,2) NULL', 'mcc' => 'VARCHAR(255) NULL'],
        'evaluations' => ['note_cc' => 'DECIMAL(10,0) NULL', 'note_composition' => 'DECIMAL(10,0) NULL'],
        'evalutes'    => ['composition' => 'TINYINT(1) NULL'],
    ];

    public function up(): void
    {
        foreach ($this->colonnes as $table => $colonnes) {
            foreach ($colonnes as $colonne => $nullable) {
                if ($this->type($table, $colonne) === 'decimal(5,2)') {
                    continue;
                }
                DB::statement("ALTER TABLE `$table` MODIFY `$colonne` DECIMAL(5,2) " . ($nullable ? 'NULL' : 'NOT NULL'));
            }
        }
    }

    public function down(): void
    {
        foreach ($this->anciens as $table => $colonnes) {
            foreach ($colonnes as $colonne => $definition) {
                DB::statement("ALTER TABLE `$table` MODIFY `$colonne` $definition");
            }
        }
    }

    private function type(string $table, string $colonne): ?string
    {
        return DB::table('information_schema.columns')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', $table)
            ->where('column_name', $colonne)
            ->value('column_type');
    }
};
