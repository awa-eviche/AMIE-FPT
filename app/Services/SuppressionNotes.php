<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Suppression des notes liées à une affectation de formateur supprimée.
 *
 * Les tables de notes n'ont aucune clé étrangère : rien ne les supprime en cascade, et rien
 * n'empêche de les laisser orphelines. Ce service cible donc précisément ce qui doit partir.
 *
 * Règles :
 *  - PPO : notes (devoirs, évaluations = contrôle continu + composition) d'une matière pour une
 *    classe, une année et un semestre. Les notes n'appartiennent pas à un formateur : si une autre
 *    affectation couvre encore la même matière (même classe, même année, ce semestre ou tous les
 *    semestres), les notes sont conservées.
 *  - APC, discipline (ressource) : ses devoirs, ses compositions et ses notes sommatives.
 *  - APC, compétence particulière : quand plus aucune affectation ne la couvre, les notes sommatives
 *    de ses critères pour les inscrits de la classe (année de l'affectation).
 *
 * Ordre : `devoirapc` et `sommations` sont en MyISAM (non annulables) ; leurs suppressions viennent
 * toujours en dernier, après les tables transactionnelles.
 */
class SuppressionNotes
{
    /**
     * @return array{devoirs: int, evaluations: int, historiques: int, conservees: bool}
     */
    public static function apresSuppressionPpo(int $classeId, int $matiereId, int $anneeId, ?int $semestre): array
    {
        $bilan = ['devoirs' => 0, 'evaluations' => 0, 'historiques' => 0, 'conservees' => false];

        $aPurger = self::semestresNonCouverts(
            $semestre ? [$semestre] : [1, 2],
            DB::table('classe_formateur_matiere')
                ->where('classe_id', $classeId)->where('matiere_id', $matiereId)
                ->where('annee_academique_id', $anneeId)->pluck('semestre')->all()
        );

        if (!$aPurger) {
            $bilan['conservees'] = true;   // une autre affectation couvre encore cette matière

            return $bilan;
        }

        $bilan['devoirs'] = DB::table('devoirs')
            ->where('classe_id', $classeId)->where('matiere_id', $matiereId)
            ->where('annee_academique_id', $anneeId)
            ->whereIn('semestre', $aPurger)->delete();

        $inscriptions = DB::table('inscriptions')->where('classe_id', $classeId)
            ->where('annee_academique_id', $anneeId)->pluck('id')->all();

        foreach (array_chunk($inscriptions, 1000) as $lot) {
            $ids = DB::table('evaluations')
                ->whereIn('inscription_id', $lot)->where('matiere_id', $matiereId)
                ->whereIn('semestre', $aPurger)
                ->pluck('id')->all();

            foreach (array_chunk($ids, 1000) as $idsLot) {
                $bilan['historiques'] += DB::table('history_notes')->whereIn('evaluation_id', $idsLot)->delete();
                $bilan['evaluations'] += DB::table('evaluations')->whereIn('id', $idsLot)->delete();
            }
        }

        return $bilan;
    }

    /**
     * Une discipline APC supprimée emporte ses notes : compositions (transactionnel), puis devoirs et
     * notes sommatives (MyISAM, en dernier).
     *
     * @return array{compositions: int, devoirs: int, sommatives: int}
     */
    public static function ressource(int $ressourceId): array
    {
        $bilan = ['compositions' => 0, 'devoirs' => 0, 'sommatives' => 0];

        $bilan['compositions'] = DB::table('evalutes')->where('ressource_id', $ressourceId)->delete();
        $bilan['devoirs'] = DB::table('devoirapc')->where('ressource_id', $ressourceId)->delete();
        $bilan['sommatives'] = DB::table('sommations')->where('ressource_id', $ressourceId)->delete();

        return $bilan;
    }

    /**
     * Notes sommatives d'une compétence particulière (par critère) une fois qu'aucune affectation
     * ne la couvre plus. À appeler après la suppression de l'affectation.
     *
     * @return int nombre de notes supprimées
     */
    public static function competenceParticuliere(int $classeId, int $competenceId, int $anneeId, ?int $semestre): int
    {
        $type = DB::table('competences')->where('id', $competenceId)->value('type');
        if ($type !== 'particuliere') {
            return 0;   // les notes sommatives des compétences générales sont portées par les disciplines
        }

        $aPurger = self::semestresNonCouverts(
            $semestre ? [$semestre] : [1, 2],
            DB::table('classe_formateur_competence')
                ->where('classe_id', $classeId)->where('competence_id', $competenceId)
                ->where('annee_academique_id', $anneeId)->pluck('semestre')->all()
        );
        if (!$aPurger) {
            return 0;
        }

        $criteres = DB::table('criteres as c')
            ->join('element_competences as e', 'e.id', '=', 'c.element_competence_id')
            ->where('e.competence_id', $competenceId)->pluck('c.id')->all();
        $inscriptions = DB::table('inscriptions')->where('classe_id', $classeId)
            ->where('annee_academique_id', $anneeId)->pluck('id')->all();
        if (!$criteres || !$inscriptions) {
            return 0;
        }

        $supprimees = 0;
        foreach (array_chunk($inscriptions, 1000) as $lot) {
            $supprimees += DB::table('sommations')
                ->whereIn('critere_id', $criteres)->whereIn('inscription_id', $lot)
                ->whereIn('semestre', $aPurger)->delete();
        }

        return $supprimees;
    }

    /**
     * Semestres demandés qu'aucune affectation restante ne couvre (une affectation sans semestre
     * couvre les deux).
     *
     * @param int[] $demandes
     * @param array<int, mixed> $semestresRestants semestre de chaque affectation restante
     * @return int[]
     */
    private static function semestresNonCouverts(array $demandes, array $semestresRestants): array
    {
        return array_values(array_filter($demandes, function (int $s) use ($semestresRestants) {
            foreach ($semestresRestants as $r) {
                if ($r === null || $r === '' || (int) $r === $s) {
                    return false;
                }
            }

            return true;
        }));
    }
}
