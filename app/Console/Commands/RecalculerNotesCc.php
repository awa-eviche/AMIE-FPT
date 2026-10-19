<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculerNotesCc extends Command
{
    protected $signature = 'notes:recalculer-cc {--corriger : Enregistre les CC recalculés}';

    protected $description = 'Recalcule le contrôle continu (PPO et APC) à partir des devoirs';

    private const MOYENNES_PPO = '(SELECT inscription_id, matiere_id, semestre, ROUND(AVG(note), 2) AS m
        FROM devoirs WHERE note IS NOT NULL GROUP BY inscription_id, matiere_id, semestre)';

    private const MOYENNES_APC = '(SELECT inscription_id, ressource_id, semestre, ROUND(AVG(note), 2) AS m
        FROM devoirapc WHERE note IS NOT NULL GROUP BY inscription_id, ressource_id, semestre)';

    private const DIFFERENT = '(%1$s IS NULL OR ABS(%1$s - a.m) > 0.005)';

    public function handle(): int
    {
        $corriger = (bool) $this->option('corriger');

        $requetes = [
            'evaluations.note_cc (PPO)' => [
                'evaluations e JOIN ' . self::MOYENNES_PPO . ' a ON a.inscription_id = e.inscription_id
                    AND a.matiere_id = e.matiere_id AND a.semestre = e.semestre',
                sprintf(self::DIFFERENT, 'e.note_cc'),
                'e.note_cc = a.m',
            ],
            'devoirs.mcc (PPO)' => [
                'devoirs d JOIN ' . self::MOYENNES_PPO . ' a ON a.inscription_id = d.inscription_id
                    AND a.matiere_id = d.matiere_id AND a.semestre = d.semestre',
                sprintf(self::DIFFERENT, 'd.mcc'),
                'd.mcc = a.m',
            ],
            'devoirapc.mcc (APC)' => [
                'devoirapc d JOIN ' . self::MOYENNES_APC . ' a ON a.inscription_id = d.inscription_id
                    AND a.ressource_id = d.ressource_id AND a.semestre = d.semestre',
                sprintf(self::DIFFERENT, 'd.mcc'),
                'd.mcc = a.m',
            ],
        ];

        foreach ($requetes as $libelle => [$jointure, $condition, $affectation]) {
            $n = DB::selectOne("SELECT COUNT(*) AS n FROM $jointure WHERE $condition")->n;

            if ($corriger && $n > 0) {
                $n = DB::update("UPDATE $jointure SET $affectation WHERE $condition");
                $this->info("$libelle : $n ligne(s) corrigée(s).");
            } else {
                $this->line("$libelle : $n ligne(s) à corriger.");
            }
        }

        if (!$corriger) {
            $this->comment('Simulation : relancer avec --corriger pour enregistrer.');
        }

        return self::SUCCESS;
    }
}
