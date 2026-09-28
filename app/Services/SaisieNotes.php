<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Avancement de la saisie des devoirs (contrôle continu) et des notes de
 * composition, par établissement et par semestre, pour l'année choisie.
 *
 * Deux règles selon la modalité de la classe :
 *  - PPO : on attend une note par apprenant et par matière. Matières attendues :
 *    celles affectées à la classe pour l'année (formateur renseigné, niveau de la
 *    classe) ; à défaut, toutes les matières du niveau.
 *  - APC : on attend une note par apprenant et par ressource des compétences
 *    générales de la classe (la composition des compétences particulières est
 *    facultative, comme dans la saisie APC de l'application). Compétences prises
 *    en compte : celles affectées à la classe pour l'année ; à défaut, toutes. Les
 *    ressources sont celles de l'année (annee_academique_id).
 *
 * Une classe est « complète » quand chaque inscrit a une note pour chaque élément
 * attendu (devoir : au moins un devoir noté ; composition : une note de composition).
 * Une classe sans élément attendu ne peut pas être validée : elle est incomplète.
 * Un établissement est complet quand toutes ses classes le sont.
 *
 * Rattachement des notes à la classe et à l'année :
 *  - devoirs (PPO et APC) et compositions (PPO : evaluations, APC : evalutes) portent
 *    leur année (annee_academique_id) ; voir AnneeDesNotes pour les bases où la colonne
 *    des évaluations n'existe pas encore (toutes les notes sont alors de 2025-2026) ;
 *  - classe : devoirs PPO = classe du devoir ; devoirs et compositions APC = classe de
 *    la ressource ; compositions PPO = classe de l'inscription, à défaut celle des
 *    devoirs du même apprenant. L'effectif d'une classe est compté en apprenants distincts.
 */
class SaisieNotes
{
    /**
     * @param array<int, array{etab: int, niveau: ?int, modalite: ?string, n: int}> $classes classes avec inscrits
     * @param array<int, string> $noms nom d'affichage par établissement
     */
    public function __construct(
        private int $anneeId,
        private array $classes,
        private array $noms,
    ) {
    }

    public function calculer(): ?array
    {
        if (!$this->classes) {
            return null;
        }

        $ppo = $apc = [];
        foreach ($this->classes as $id => $c) {
            ($c['modalite'] === 'APC') ? $apc[] = $id : $ppo[] = $id;
        }

        $attendus = $this->attendus($ppo, $apc);
        $notes = $this->notes($ppo, $apc);

        $etabs = [];
        foreach ($this->classes as $classeId => $c) {
            $elements = $attendus[$classeId] ?? [];
            $e = &$etabs[$c['etab']];
            $e ??= ['classes' => 0, 'ppo' => 0, 'apc' => 0, 'sans_attendu' => 0];
            $e['classes']++;
            $c['modalite'] === 'APC' ? $e['apc']++ : $e['ppo']++;
            $elements ?: $e['sans_attendu']++;

            foreach (['devoirs', 'composition'] as $type) {
                foreach ([1, 2] as $sem) {
                    $a = &$e[$type][$sem];
                    $a ??= ['ok' => 0, 'got' => 0, 'exp' => 0];
                    $exp = $c['n'] * count($elements);
                    $got = 0;
                    foreach ($elements as $element) {
                        $got += min($c['n'], $notes[$type][$sem][$classeId][$element] ?? 0);
                    }
                    $a['exp'] += $exp;
                    $a['got'] += $got;
                    $a['ok'] += ($exp > 0 && $got >= $exp) ? 1 : 0;
                    unset($a);
                }
            }
            unset($e);
        }

        $lignes = [];
        foreach ($etabs as $id => $e) {
            $ligne = [
                'nom' => $this->noms[$id] ?? "Établissement $id",
                'classes' => $e['classes'], 'ppo' => $e['ppo'], 'apc' => $e['apc'], 'sans_attendu' => $e['sans_attendu'],
            ];
            foreach (['devoirs', 'composition'] as $type) {
                foreach ([1, 2] as $sem) {
                    $a = $e[$type][$sem];
                    $ligne[$type]["s$sem"] = [
                        'ok' => $a['ok'],
                        // arrondi vers le bas : 99,6 % ne doit pas s'afficher 100 %
                        'pct' => $a['exp'] ? floor(1000 * $a['got'] / $a['exp']) / 10 : 0,
                        'complet' => $e['classes'] > 0 && $a['ok'] === $e['classes'],
                    ];
                }
            }
            $lignes[] = $ligne;
        }

        $cle = fn ($l) => [
            $l['composition']['s1']['complet'] && $l['composition']['s2']['complet'],
            $l['composition']['s1']['complet'], $l['composition']['s2']['complet'],
            $l['composition']['s1']['pct'] + $l['composition']['s2']['pct'],
            $l['devoirs']['s1']['pct'] + $l['devoirs']['s2']['pct'],
        ];
        usort($lignes, fn ($a, $b) => $cle($b) <=> $cle($a) ?: strcmp($a['nom'], $b['nom']));

        $compte = fn (callable $f) => count(array_filter($lignes, $f));

        return [
            'resume' => [
                'etablissements' => count($lignes),
                'composition_s1' => $compte(fn ($l) => $l['composition']['s1']['complet']),
                'composition_s2' => $compte(fn ($l) => $l['composition']['s2']['complet']),
                'composition_les_deux' => $compte(fn ($l) => $l['composition']['s1']['complet'] && $l['composition']['s2']['complet']),
                'devoirs_s1' => $compte(fn ($l) => $l['devoirs']['s1']['complet']),
                'devoirs_s2' => $compte(fn ($l) => $l['devoirs']['s2']['complet']),
            ],
            'lignes' => $lignes,
        ];
    }

    /**
     * Éléments attendus par classe : matières (PPO) ou ressources (APC).
     *
     * @return array<int, array<int, int>> classe_id => ids
     */
    private function attendus(array $ppo, array $apc): array
    {
        $attendus = [];

        if ($ppo) {
            $affectees = DB::table('classe_formateur_matiere as f')
                ->join('classes as c', 'c.id', '=', 'f.classe_id')
                ->join('matieres as m', fn ($j) => $j->on('m.id', '=', 'f.matiere_id')->on('m.niveau_etude_id', '=', 'c.niveau_etude_id'))
                ->where('f.annee_academique_id', $this->anneeId)
                ->whereNotNull('f.formateur_id')
                ->whereIn('f.classe_id', $ppo)
                ->select('f.classe_id', 'f.matiere_id')->distinct()->get()
                ->groupBy('classe_id')->map(fn ($r) => $r->pluck('matiere_id')->all());

            $niveaux = DB::table('matieres')
                ->whereIn('niveau_etude_id', array_unique(array_filter(array_map(fn ($id) => $this->classes[$id]['niveau'], $ppo))))
                ->get(['id', 'niveau_etude_id'])
                ->groupBy('niveau_etude_id')->map(fn ($r) => $r->pluck('id')->all());

            foreach ($ppo as $id) {
                $attendus[$id] = $affectees[$id] ?? $niveaux[$this->classes[$id]['niveau']] ?? [];
            }
        }

        if ($apc) {
            $affectees = DB::table('classe_formateur_competence')
                ->where('annee_academique_id', $this->anneeId)
                ->whereIn('classe_id', $apc)
                ->select('classe_id', 'competence_id')->distinct()->get()
                ->groupBy('classe_id')->map(fn ($r) => $r->pluck('competence_id')->all());

            $ressources = DB::table('ressources as r')
                ->join('competences as k', 'k.id', '=', 'r.competence_id')
                ->where('k.type', 'generale')
                ->whereIn('r.classe_id', $apc)
                // ressources de l'année (colonne ajoutée par la migration)
                ->when(AnneeDesNotes::aUneColonne('ressources'), fn ($q) => $q->where('r.annee_academique_id', $this->anneeId))
                ->get(['r.id', 'r.classe_id', 'r.competence_id'])
                ->groupBy('classe_id');

            foreach ($apc as $id) {
                $liste = $ressources[$id] ?? collect();
                if (isset($affectees[$id])) {
                    $liste = $liste->filter(fn ($r) => in_array($r->competence_id, $affectees[$id]));
                }
                $attendus[$id] = $liste->pluck('id')->all();
            }
        }

        return $attendus;
    }

    /**
     * Apprenants distincts ayant une note, par type, semestre, classe et élément.
     *
     * @return array<string, array<int, array<int, array<int, array<int, int>>>>>
     */
    private function notes(array $ppo, array $apc): array
    {
        $notes = [];
        $ranger = function (string $type, $lignes) use (&$notes) {
            foreach ($lignes as $l) {
                $notes[$type][(int) $l->semestre][$l->classe_id][$l->element] = (int) $l->k;
            }
        };

        if ($ppo) {
            $ranger('devoirs', DB::table('devoirs')
                ->where('annee_academique_id', $this->anneeId)->whereNotNull('note')->whereIn('classe_id', $ppo)
                ->groupBy('classe_id', 'matiere_id', 'semestre')
                ->select('classe_id', 'matiere_id as element', 'semestre', DB::raw('COUNT(DISTINCT inscription_id) as k'))->get());
        }
        if ($apc) {
            $ranger('devoirs', DB::table('devoirapc as d')
                ->join('ressources as r', 'r.id', '=', 'd.ressource_id')
                ->where('d.annee_academique_id', $this->anneeId)->whereNotNull('d.note')->whereIn('r.classe_id', $apc)
                ->groupBy('r.classe_id', 'd.ressource_id', 'd.semestre')
                ->select('r.classe_id as classe_id', 'd.ressource_id as element', 'd.semestre', DB::raw('COUNT(DISTINCT d.inscription_id) as k'))->get());
        }

        if ($ppo) {
            // 1) Inscriptions valides : tout se calcule en SQL.
            $reelles = DB::table('evaluations as ev')
                ->join('inscriptions as i', 'i.id', '=', 'ev.inscription_id')
                ->join('apprenants as a', 'a.id', '=', 'i.apprenant_id')
                ->where('a.isDeleted', 0)
                ->whereNotNull('ev.note_composition')->whereIn('ev.semestre', ['1', '2'])
                ->whereIn('i.classe_id', $ppo)
                ->groupBy('i.classe_id', 'ev.matiere_id', 'ev.semestre')
                ->select('i.classe_id as classe_id', 'ev.matiere_id as element', 'ev.semestre',
                    DB::raw('COUNT(DISTINCT ev.inscription_id) as k'));

            if (AnneeDesNotes::restreindre($reelles, 'evaluations', 'ev', $this->anneeId)) {
                $ranger('composition', $reelles->get());

                // 2) Notes orphelines (inscription supprimée) : classe déduite des devoirs.
                $classeDe = InscriptionClasses::orphelines();
                if ($classeDe) {
                    $ppoSet = array_flip($ppo);
                    $orphelines = DB::table('evaluations as ev')
                        ->whereNotExists(InscriptionClasses::valide('ev.inscription_id'))
                        ->whereNotNull('ev.note_composition')->whereIn('ev.semestre', ['1', '2'])
                        ->select('ev.inscription_id', 'ev.matiere_id', 'ev.semestre')->distinct();
                    AnneeDesNotes::restreindre($orphelines, 'evaluations', 'ev', $this->anneeId);

                    $vus = [];
                    foreach ($orphelines->cursor() as $e) {
                        $classe = $classeDe[$e->inscription_id] ?? null;
                        if ($classe !== null && isset($ppoSet[$classe])) {
                            $vus[(int) $e->semestre][$classe][$e->matiere_id][$e->inscription_id] = true;
                        }
                    }
                    foreach ($vus as $sem => $parClasse) {
                        foreach ($parClasse as $classe => $parMatiere) {
                            foreach ($parMatiere as $matiere => $inscriptions) {
                                $notes['composition'][$sem][$classe][$matiere]
                                    = ($notes['composition'][$sem][$classe][$matiere] ?? 0) + count($inscriptions);
                            }
                        }
                    }
                }
            }
        }

        if ($apc) {
            $compositions = DB::table('evalutes as e')
                ->join('ressources as r', 'r.id', '=', 'e.ressource_id')
                ->whereNotNull('e.composition')->whereIn('r.classe_id', $apc)
                ->groupBy('r.classe_id', 'e.ressource_id', 'e.semestre')
                ->select('r.classe_id as classe_id', 'e.ressource_id as element', 'e.semestre', DB::raw('COUNT(DISTINCT e.inscription_id) as k'));

            if (AnneeDesNotes::restreindre($compositions, 'evalutes', 'e', $this->anneeId)) {
                $ranger('composition', $compositions->get());
            }
        }

        return $notes;
    }
}
