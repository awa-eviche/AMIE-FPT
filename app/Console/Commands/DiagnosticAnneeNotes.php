<?php

namespace App\Console\Commands;

use App\Models\AnneeAcademique;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Contrôle (lecture seule par défaut) du rattachement des notes, absences, ressources et
 * affectations à une année académique. À lancer sur le serveur avant et après le
 * déploiement :  php artisan notes:diagnostic
 *
 * Avec --corriger, rattrape les lignes restées sans année (par exemple créées par l'ancien
 * code entre le déploiement de la migration et celui du code). Idempotent.
 */
class DiagnosticAnneeNotes extends Command
{
    protected $signature = 'notes:diagnostic {--corriger : Renseigne l\'année des lignes qui en sont dépourvues}';

    protected $description = 'Contrôle le rattachement des notes, absences, ressources et affectations aux années académiques';

    /** Tables rattachées à une année et règle de rattrapage. */
    private const TABLES = [
        'devoirs' => 'defaut', 'devoirapc' => 'defaut', 'evaluations' => 'defaut', 'evalutes' => 'defaut',
        'sommations' => 'defaut', 'classe_formateur_matiere' => 'defaut', 'classe_formateur_competence' => 'defaut',
        'absences' => 'absences', 'ressources' => 'ressources',
    ];

    private int $problemes = 0;

    public function handle(): int
    {
        $anneeDefaut = AnneeAcademique::where('code', config('constants.annee_notes'))->first();
        $this->line('Année des notes (constants.annee_notes) : ' . config('constants.annee_notes')
            . ($anneeDefaut ? " (id {$anneeDefaut->id})" : ''));
        if (!$anneeDefaut) {
            $this->error("Cette année n'existe pas dans annee_academiques : les migrations et le rattrapage sont impossibles.");

            return self::FAILURE;
        }

        $this->section('1. Colonnes et lignes sans année');
        $lignes = [];
        foreach (self::TABLES as $table => $regle) {
            if (!Schema::hasTable($table)) {
                $lignes[] = [$table, 'table absente', '-', $this->etat('ERREUR')];
                continue;
            }
            if (!Schema::hasColumn($table, 'annee_academique_id')) {
                $lignes[] = [$table, 'COLONNE MANQUANTE (migration non passée)', '-', $this->etat('ERREUR')];
                continue;
            }
            $sansAnnee = DB::table($table)->whereNull('annee_academique_id')->count();
            $parAnnee = DB::table($table)->whereNotNull('annee_academique_id')->groupBy('annee_academique_id')
                ->select('annee_academique_id as a', DB::raw('COUNT(*) as c'))->pluck('c', 'a')
                ->mapWithKeys(fn ($c, $a) => [AnneeAcademique::find($a)?->code ?? "#$a" => $c])->toJson();
            $lignes[] = [$table, "$sansAnnee sans année", $parAnnee, $this->etat($sansAnnee ? 'ERREUR' : 'OK')];
        }
        $this->table(['Table', 'Sans année', 'Répartition par année', 'État'], $lignes);

        $this->section('2. Cohérence');
        $controles = [];
        if (Schema::hasColumn('ressources', 'annee_academique_id') && Schema::hasColumn('devoirapc', 'annee_academique_id')) {
            $n = DB::table('ressources as r')->join('devoirapc as d', 'd.ressource_id', '=', 'r.id')
                ->whereColumn('d.annee_academique_id', '<>', 'r.annee_academique_id')->distinct()->count('r.id');
            $controles[] = ['Ressources dont l\'année diffère de celle de leurs devoirs', $n, $this->etat($n ? 'ATTENTION' : 'OK')];
        }
        if (Schema::hasColumn('absences', 'annee_academique_id')) {
            $n = DB::table('absences as a')->join('inscriptions as i', 'i.id', '=', 'a.inscription_id')
                ->whereColumn('a.annee_academique_id', '<>', 'i.annee_academique_id')->count();
            $controles[] = ['Absences dont l\'année diffère de celle de leur inscription', $n, $this->etat($n ? 'ATTENTION' : 'OK')];
        }
        $controles[] = ['Classes sans modalité PPO/APC', DB::table('classes')->where(fn ($q) => $q->whereNull('modalite')
            ->orWhereNotIn('modalite', ['PPO', 'APC']))->count(), null];
        $this->table(['Contrôle', 'Nombre', 'État'], array_map(fn ($c) => [$c[0], $c[1], $c[2] ?? $this->etat($c[1] ? 'ATTENTION' : 'OK')], $controles));

        $this->section('3. Données orphelines (n\'empêchent pas le fonctionnement, mais ne sont rattachables à aucune classe)');
        $orphelines = [
            ['Évaluations sans inscription', DB::table('evaluations as e')->leftJoin('inscriptions as i', 'i.id', '=', 'e.inscription_id')->whereNull('i.id')->count()],
            ['Évaluations sans matière', DB::table('evaluations as e')->leftJoin('matieres as m', 'm.id', '=', 'e.matiere_id')->whereNull('m.id')->count()],
            ['Devoirs PPO sans inscription', DB::table('devoirs as d')->leftJoin('inscriptions as i', 'i.id', '=', 'd.inscription_id')->whereNull('i.id')->count()],
            ['Devoirs PPO dont la classe n\'existe plus', DB::table('devoirs as d')->leftJoin('classes as c', 'c.id', '=', 'd.classe_id')->whereNull('c.id')->count()],
            ['Devoirs APC sans ressource', DB::table('devoirapc as d')->leftJoin('ressources as r', 'r.id', '=', 'd.ressource_id')->whereNull('r.id')->count()],
            ['Compositions APC sans ressource', DB::table('evalutes as e')->leftJoin('ressources as r', 'r.id', '=', 'e.ressource_id')->whereNull('r.id')->count()],
            ["Groupes d'évaluations en doublon (même inscription, matière et semestre)", DB::selectOne('select count(*) c from (select 1 from evaluations group by inscription_id, matiere_id, semestre having count(*) > 1) x')->c],
            ['Absences sans inscription', DB::table('absences as a')->leftJoin('inscriptions as i', 'i.id', '=', 'a.inscription_id')->whereNull('i.id')->count()],
        ];
        $this->table(['Anomalie', 'Nombre', 'État'], array_map(fn ($o) => [$o[0], $o[1], $this->etat($o[1] ? 'INFO' : 'OK', false)], $orphelines));

        $this->section('4. Moteurs de stockage');
        // Alias explicites : MySQL 8 renvoie les colonnes d'information_schema en majuscules.
        $moteurs = DB::table('information_schema.tables')->where('table_schema', DB::raw('DATABASE()'))
            ->whereIn('table_name', array_keys(self::TABLES))
            ->select('table_name as nom', 'engine as moteur')->pluck('moteur', 'nom');
        $myisam = $moteurs->filter(fn ($e) => strtolower((string) $e) === 'myisam')->keys()->all();
        $this->line($myisam
            ? 'MyISAM (écritures non annulables en cas d\'erreur) : ' . implode(', ', $myisam)
            : 'Toutes les tables sont en InnoDB.');

        if ($this->option('corriger')) {
            $this->section('Rattrapage des lignes sans année');
            $this->corriger($anneeDefaut);
        } elseif ($this->problemes) {
            $this->newLine();
            $this->warn("{$this->problemes} problème(s) bloquant(s). Corrigez les lignes sans année avec : php artisan notes:diagnostic --corriger");
        }

        $this->newLine();
        $this->line($this->problemes ? '<fg=red>Diagnostic : à corriger.</>' : '<fg=green>Diagnostic : aucune anomalie bloquante.</>');

        return $this->problemes ? self::FAILURE : self::SUCCESS;
    }

    private function corriger(AnneeAcademique $defaut): void
    {
        $suivante = AnneeAcademique::where('code', '2026-2027')->first();
        $resultat = [];

        foreach (self::TABLES as $table => $regle) {
            if (!Schema::hasColumn($table, 'annee_academique_id')) {
                $resultat[] = [$table, 'colonne absente : lancez d\'abord php artisan migrate'];
                continue;
            }
            $avant = DB::table($table)->whereNull('annee_academique_id')->count();
            if (!$avant) {
                continue;
            }

            if (in_array($table, ['evaluations', 'evalutes', 'sommations'], true)) {
                // Notes créées sans année après la migration (ancien code) : année de leur inscription.
                DB::statement("UPDATE $table n JOIN inscriptions i ON i.id = n.inscription_id
                    SET n.annee_academique_id = i.annee_academique_id
                    WHERE n.annee_academique_id IS NULL AND i.annee_academique_id IS NOT NULL");
            }

            if ($regle === 'absences') {
                DB::statement('UPDATE absences a JOIN inscriptions i ON i.id = a.inscription_id
                    SET a.annee_academique_id = i.annee_academique_id
                    WHERE a.annee_academique_id IS NULL AND i.annee_academique_id IS NOT NULL');
            } elseif ($regle === 'ressources') {
                DB::statement('UPDATE ressources r JOIN (
                        SELECT ressource_id, MIN(annee_academique_id) AS annee FROM devoirapc
                        WHERE annee_academique_id IS NOT NULL GROUP BY ressource_id
                    ) d ON d.ressource_id = r.id SET r.annee_academique_id = d.annee WHERE r.annee_academique_id IS NULL');
                $fin = ($defaut->dateFin ?? '2026-07-31') . ' 23:59:59';
                DB::table('ressources')->whereNull('annee_academique_id')->where('created_at', '<=', $fin)
                    ->update(['annee_academique_id' => $defaut->id]);
                DB::table('ressources')->whereNull('annee_academique_id')
                    ->update(['annee_academique_id' => $suivante->id ?? $defaut->id]);
            }
            DB::table($table)->whereNull('annee_academique_id')->update(['annee_academique_id' => $defaut->id]);

            $resultat[] = [$table, $avant . ' ligne(s) rattachée(s)'];
        }

        $resultat ? $this->table(['Table', 'Rattrapage'], $resultat) : $this->info('Rien à rattraper.');

        // Recompte après rattrapage : le verdict final doit refléter l'état corrigé.
        $this->problemes = 0;
        foreach (array_keys(self::TABLES) as $table) {
            if (!Schema::hasColumn($table, 'annee_academique_id') || DB::table($table)->whereNull('annee_academique_id')->exists()) {
                $this->problemes++;
            }
        }
    }

    private function section(string $titre): void
    {
        $this->newLine();
        $this->line("<options=bold>$titre</>");
    }

    private function etat(string $etat, bool $bloquant = true): string
    {
        if ($etat === 'ERREUR' && $bloquant) {
            $this->problemes++;
        }

        return match ($etat) {
            'OK' => '<fg=green>OK</>',
            'ATTENTION' => '<fg=yellow>ATTENTION</>',
            'INFO' => '<fg=cyan>INFO</>',
            default => '<fg=red>ERREUR</>',
        };
    }
}
