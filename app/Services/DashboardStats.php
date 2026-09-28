<?php

namespace App\Services;

use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Construit les indicateurs et graphiques du tableau de bord selon le profil
 * de l'utilisateur connecté.
 *
 * Chaque méthode retourne la même structure :
 *  - type, titre, sous_titre
 *  - annee_id, annees (sélecteur d'année académique, null si non pertinent)
 *  - kpis   : [label, valeur, icone, couleur, modal?]
 *  - charts : [id, titre, type (bar|hbar|doughnut), labels, datasets, span]
 */
class DashboardStats
{
    /** Rôles qui voient les chiffres de tout le pays (agrégats uniquement). */
    private const ROLES_NATIONAL = [
        'superadmin', 'agent', 'chef_de_service', 'autorite', 'dage', 'dgfpt', 'Ministre',
    ];

    /**
     * Contenu du dashboard d'établissement selon la fonction. Un compte cumulant
     * plusieurs rôles prend la première variante qui correspond (la plus étendue).
     */
    private const VARIANTES_ETABLISSEMENT = [
        'direction'    => ['chef_etablissement', 'directeur_etude', 'censeur'],
        'travaux'      => ['chef_de_travaux'],
        'surveillance' => ['surveillant'],
        'gestion'      => ['intendant', 'gestionnaire', 'comptable_matiere'],
        'secretariat'  => ['assistante'],
    ];

    /** @var array<int>|null Établissements couverts (null = tous). */
    private ?array $etabIds = null;

    private ?int $anneeId = null;

    /** @var Collection|null Lignes à plat de l'année (voir lignes()). */
    private ?Collection $lignes = null;

    /** @var Collection|null Moyennes par inscription et par semestre (voir moyennes()). */
    private ?Collection $moyennes = null;

    /** @var array<int,int>|null Apprenants distincts par année (voir volumesParAnnee()). */
    private ?array $volumes = null;

    /** Effectif minimal d'évalués pour afficher les statistiques de notes d'un semestre. */
    private const MIN_EVALUES = 10;

    /** Durée de mise en cache des tableaux de bord agrégés (national, IA, établissement). */
    private const CACHE_MINUTES = 10;

    public static function forUser(User $user, ?int $anneeId = null): array
    {
        $stats = new self();
        $annee = $anneeId ?: 'auto';
        $ttl = now()->addMinutes(self::CACHE_MINUTES);

        if ($user->hasRole(self::ROLES_NATIONAL)) {
            return Cache::remember("dashboard:national:$annee", $ttl, fn () => $stats->national($anneeId));
        }
        // Les inspecteurs de spécialité rattachés à une IA voient le périmètre de cette IA.
        if ($user->hasRole('ia') || ($user->hasRole('Inspecteur de spécialité') && $user->inspecteur?->ia_id)) {
            $iaId = $user->inspecteur?->ia_id;

            return Cache::remember("dashboard:ia:$iaId:$annee", $ttl, fn () => $stats->ia($user, $anneeId));
        }
        if ($user->hasRole(array_merge(...array_values(self::VARIANTES_ETABLISSEMENT))) && $user->etablissementId()) {
            return self::dashboardEtablissement($stats, $user, $annee, $anneeId, $ttl);
        }
        if ($user->hasRole('formateur')) {
            return $stats->formateur($user, $anneeId);
        }
        if ($user->hasRole('apprenant') && $user->inscription_id) {
            return $stats->apprenant($user);
        }
        if ($user->etablissementId()) {
            return self::dashboardEtablissement($stats, $user, $annee, $anneeId, $ttl);
        }

        return ['type' => 'vide', 'titre' => 'Tableau de bord', 'sous_titre' => null,
            'annee_id' => null, 'annees' => [], 'kpis' => [], 'charts' => []];
    }

    private static function dashboardEtablissement(self $stats, User $user, $annee, ?int $anneeId, $ttl): array
    {
        $etab = $user->etablissementId();
        // Rôle non prévu mais rattaché à un établissement : vue la plus restreinte.
        $variante = 'secretariat';
        foreach (self::VARIANTES_ETABLISSEMENT as $nom => $roles) {
            if ($user->hasRole($roles)) {
                $variante = $nom;
                break;
            }
        }

        return Cache::remember("dashboard:etab:$etab:$variante:$annee", $ttl,
            fn () => $stats->etablissement($etab, $anneeId, $variante));
    }

    /* ------------------------------------------------------------------ */
    /*  Profils                                                            */
    /* ------------------------------------------------------------------ */

    public function national(?int $anneeId): array
    {
        $this->etabIds = null;
        $this->anneeId = $this->resolveAnnee($anneeId);

        $effectif = $this->apprenantsCount();

        return [
            'type' => 'national',
            'titre' => 'Tableau de bord national',
            'sous_titre' => 'Vue d\'ensemble de la formation professionnelle et technique',
            'annee_id' => $this->anneeId,
            'annees' => $this->annees(),
            'kpis' => [
                $this->kpi('Établissements actifs', $this->etablissementsCount(), 'building', 'orange', 'dfpt.getalletablissement', 'Établissements', true),
                $this->kpi('Apprenants inscrits', $effectif, 'academic-cap', 'green', 'dfpt.getallapprenant', 'Apprenants'),
                $this->kpi('Classes', $this->classesCount(), 'collection', 'orange'),
                $this->kpi('Filières', $this->filieresCount(), 'briefcase', 'green', 'Dfpt.Filiere', 'Filières', true),
                $this->kpi('Métiers', $this->lignes()->pluck('metier_id')->filter()->unique()->count(), 'wrench', 'orange', 'Dfpt.Metier', 'Métiers', true),
                $this->kpi('Personnel', $this->personnelCount(), 'users', 'green'),
            ],
            'charts' => array_values(array_filter([
                $this->chartSexe(),
                $this->chartEvolutionInscriptions(),
                $this->chartParZone('region'),
                $this->chartTypesEtablissement(),
                $this->chartTopEtablissements(),
                $this->chartParSecteur(),
                $this->chartParMetier(),
                $this->chartUtilisateursParProfil(),
            ])),
            'saisie_url' => route('dashboard.saisie', ['annee' => $this->anneeId]),
        ];
    }

    /** Fixe le périmètre (établissements) d'une IA et retourne [ia, ids des départements]. */
    private function perimetreIa(User $user): array
    {
        $ia = $user->inspecteur?->ia;
        $departementIds = $ia ? $ia->departements()->pluck('departements.id')->all() : [];

        $this->etabIds = DB::table('etablissements as e')
            ->join('communes as co', 'co.id', '=', 'e.commune_id')
            ->whereIn('co.departement_id', $departementIds ?: [0])
            ->pluck('e.id')->all();

        return [$ia, $departementIds];
    }

    /**
     * Saisie des devoirs et compositions pour le national et les IA (chargée à part,
     * mise en cache comme le reste du dashboard).
     */
    public static function saisieForUser(User $user, ?int $anneeId = null): ?array
    {
        $stats = new self();
        $annee = $anneeId ?: 'auto';
        $ttl = now()->addMinutes(self::CACHE_MINUTES);

        if ($user->hasRole(self::ROLES_NATIONAL)) {
            return Cache::remember("dashboard:saisie:national:$annee", $ttl, function () use ($stats, $anneeId) {
                $stats->anneeId = $stats->resolveAnnee($anneeId);

                return $stats->saisieNotes();
            });
        }
        if ($user->hasRole('ia') || ($user->hasRole('Inspecteur de spécialité') && $user->inspecteur?->ia_id)) {
            return Cache::remember("dashboard:saisie:ia:{$user->inspecteur?->ia_id}:$annee", $ttl, function () use ($stats, $user, $anneeId) {
                $stats->perimetreIa($user);
                $stats->anneeId = $stats->resolveAnnee($anneeId);

                return $stats->saisieNotes();
            });
        }

        return null;
    }

    public function ia(User $user, ?int $anneeId): array
    {
        [$ia, $departementIds] = $this->perimetreIa($user);
        $this->anneeId = $this->resolveAnnee($anneeId);

        return [
            'type' => 'ia',
            'titre' => 'Tableau de bord — ' . ($ia->nom ?? 'Inspection d\'académie'),
            'sous_titre' => count($departementIds) . ' département(s) sous votre juridiction',
            'annee_id' => $this->anneeId,
            'annees' => $this->annees(),
            'kpis' => [
                $this->kpi('Établissements actifs', $this->etablissementsCount(), 'building', 'orange', 'ia.getAllEtablissement', 'Établissements', true),
                $this->kpi('Apprenants inscrits', $this->apprenantsCount(), 'academic-cap', 'green', 'ia.getAllApprenants', 'Apprenants'),
                $this->kpi('Classes', $this->classesCount(), 'collection', 'orange'),
                $this->kpi('Personnel', $this->personnelCount(), 'users', 'green'),
            ],
            'charts' => array_values(array_filter([
                $this->chartSexe(),
                $this->chartEvolutionInscriptions(),
                $this->chartParZone('departement'),
                $this->chartTypesEtablissement(),
                $this->chartTopEtablissements(),
                $this->chartParSecteur(),
                $this->chartParMetier(),
                $this->chartMentions(),
                $this->chartReussite('filiere'),
            ])),
            'saisie_url' => route('dashboard.saisie', ['annee' => $this->anneeId]),
        ];
    }

    public function etablissement(int $etablissementId, ?int $anneeId, string $variante = 'direction'): array
    {
        $this->etabIds = [$etablissementId];
        $this->anneeId = $this->resolveAnnee($anneeId);

        $nom = DB::table('etablissements')->where('id', $etablissementId)->value('nom');

        $apprenants = fn (string $c) => $this->kpi('Apprenants inscrits', $this->apprenantsCount(), 'academic-cap', $c, 'etablissements.get-all-apprenant', 'Apprenants');
        $classes = fn (string $c) => $this->kpi('Classes', $this->classesCount(), 'collection', $c);
        $filieres = fn (string $c) => $this->kpi('Filières', $this->filieresCount(), 'briefcase', $c, 'etablissements.getAllFilliere', 'Filières', true);
        $personnel = fn (string $c) => $this->kpi('Personnel', $this->personnelCount(), 'users', $c, 'etablissements.get-all-personnel', 'Personnels', true);

        [$sousTitre, $kpis, $charts] = match ($variante) {
            'travaux' => [
                'Effectifs, filières, formateurs et résultats',
                [$apprenants('orange'), $classes('green'), $filieres('orange'), $personnel('green')],
                [$this->chartParFiliere(), $this->chartParMetier(), $this->chartEffectifParClasse(),
                    $this->chartPersonnelParProfil(), $this->chartMentions(), $this->chartReussite('classe')],
            ],
            'surveillance' => $this->varianteSurveillance($apprenants, $classes),
            'gestion' => [
                'Effectifs, inscriptions et personnel',
                [$apprenants('orange'), $classes('green'), $personnel('orange')],
                [$this->chartSexe(), $this->chartEffectifParClasse(), $this->chartPersonnelParProfil(),
                    $this->chartEvolutionInscriptions()],
            ],
            'secretariat' => [
                'Effectifs et évolution des inscriptions',
                [$apprenants('orange'), $classes('green'), $filieres('orange')],
                [$this->chartSexe(), $this->chartParFiliere(), $this->chartEffectifParClasse(),
                    $this->chartEvolutionInscriptions()],
            ],
            default => [   // direction : chef d'établissement, directeur des études, censeur
                'Situation de votre établissement',
                [$apprenants('orange'), $classes('green'), $filieres('orange'), $personnel('green')],
                [$this->chartSexe(), $this->chartParFiliere(), $this->chartParMetier(), $this->chartEffectifParClasse(),
                    $this->chartPersonnelParProfil(), $this->chartMentions(), $this->chartReussite('classe'),
                    $this->chartAbsences(), $this->chartEvolutionInscriptions()],
            ],
        };

        return [
            'type' => 'etablissement',
            'variante' => $variante,
            'titre' => 'Tableau de bord' . ($nom ? ' — ' . $nom : ''),
            'sous_titre' => $sousTitre,
            'annee_id' => $this->anneeId,
            'annees' => $this->annees(),
            'kpis' => $kpis,
            'charts' => array_values(array_filter($charts)),
        ];
    }

    /** Surveillant : effectifs et suivi des absences et retards (pas de notes ni de personnel). */
    private function varianteSurveillance(callable $apprenants, callable $classes): array
    {
        $t = $this->absencesBase()
            ->selectRaw('COALESCE(SUM(ab.nombre_heure_absence),0) as absences, COALESCE(SUM(ab.nombre_heure_retard),0) as retards,
                COALESCE(SUM(CASE WHEN ab.justifie = 0 THEN ab.nombre_heure_absence ELSE 0 END),0) as non_justifiees')
            ->first();

        return [
            'Effectifs et suivi des absences et retards',
            [
                $apprenants('orange'),
                $classes('green'),
                $this->kpi('Heures d\'absence', (int) $t->absences, 'clock', 'orange'),
                $this->kpi('Heures de retard', (int) $t->retards, 'clock', 'green'),
                $this->kpi('Absences non justifiées (heures)', (int) $t->non_justifiees, 'clock', 'orange'),
            ],
            [$this->chartSexe(), $this->chartEffectifParClasse(), $this->chartAbsences(), $this->chartAbsencesParClasse()],
        ];
    }

    public function formateur(User $user, ?int $anneeId): array
    {
        $annees = $this->anneesFormateur($user);
        $this->anneeId = $this->resolveAnnee($anneeId, $annees);

        // Affectations de l'année : matières (PPO) et compétences (APC).
        $matieres = DB::table('classe_formateur_matiere')
            ->where('formateur_id', $user->id)->where('annee_academique_id', $this->anneeId)
            ->select('classe_id', 'matiere_id')->distinct()->get();
        $competences = DB::table('classe_formateur_competence')
            ->where('formateur_id', $user->id)->where('annee_academique_id', $this->anneeId)
            ->select('classe_id', 'competence_id')->distinct()->get();
        $classeIds = $matieres->pluck('classe_id')->merge($competences->pluck('classe_id'))->unique()->values()->all();

        $inscrits = fn () => DB::table('inscriptions as i')
            ->join('apprenants as a', 'a.id', '=', 'i.apprenant_id')
            ->where('a.isDeleted', 0)
            ->where('i.annee_academique_id', $this->anneeId)
            ->whereIn('i.classe_id', $classeIds ?: [0]);

        $parClasse = $inscrits()
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            ->groupBy('c.id', 'c.libelle')
            ->select('c.libelle', DB::raw('COUNT(DISTINCT a.id) as total'))
            ->orderByDesc('total')->limit(15)->get();

        $sexe = $inscrits()
            ->groupBy('a.sexe')
            ->select('a.sexe', DB::raw('COUNT(DISTINCT a.id) as total'))->get();

        // Notes PPO du formateur, pour l'année choisie.
        $notes = collect();
        if ($matieres->isNotEmpty()) {
            $requete = DB::table('evaluations as e')
                ->join('inscriptions as i', 'i.id', '=', 'e.inscription_id')
                ->join('matieres as m', 'm.id', '=', 'e.matiere_id')
                ->joinSub(DB::table('classe_formateur_matiere')
                    ->where('formateur_id', $user->id)->where('annee_academique_id', $this->anneeId)
                    ->select('classe_id', 'matiere_id')->distinct(), 'aff', fn ($j) => $j
                    ->on('aff.classe_id', '=', 'i.classe_id')
                    ->on('aff.matiere_id', '=', 'e.matiere_id'))
                ->groupBy('m.id', 'm.nom')
                ->select('m.nom', DB::raw('AVG(e.note_cc) as cc'), DB::raw('AVG(e.note_composition) as comp'))
                ->orderBy('m.nom')->limit(15);

            if (AnneeDesNotes::restreindre($requete, 'evaluations', 'e', $this->anneeId)) {
                $notes = $requete->get();
            }
        }

        $kpis = [
            $this->kpi('Classes', count($classeIds), 'collection', 'orange'),
            $this->kpi('Apprenants', $inscrits()->distinct()->count('a.id'), 'academic-cap', 'green'),
        ];
        if ($matieres->isNotEmpty()) {
            $kpis[] = $this->kpi('Matières (PPO)', $matieres->pluck('matiere_id')->unique()->count(), 'book', 'orange');
        }
        if ($competences->isNotEmpty()) {
            $kpis[] = $this->kpi('Compétences (APC)', $competences->pluck('competence_id')->unique()->count(), 'book', 'green');
        }

        return [
            'type' => 'formateur',
            'titre' => 'Mes enseignements',
            'sous_titre' => 'Classes, matières et compétences qui vous sont confiées',
            'annee_id' => $this->anneeId,
            'annees' => $this->anneesList(array_keys($annees)),
            'kpis' => $kpis,
            'charts' => array_values(array_filter([
                $this->donut('sexe', 'Répartition des apprenants par sexe', $this->sexeSeries($sexe)),
                $this->bar('classes', 'Effectif par classe', $parClasse->pluck('libelle')->all(),
                    [['label' => 'Apprenants', 'data' => $parClasse->pluck('total')->map(fn ($v) => (int) $v)->all()]],
                    'hbar', 2),
                $notes->isEmpty() ? null : $this->bar('notes', 'Moyenne des notes par matière (sur 20)',
                    $notes->pluck('nom')->all(),
                    [
                        ['label' => 'Contrôle continu', 'data' => $notes->pluck('cc')->map(fn ($v) => round((float) $v, 2))->all()],
                        ['label' => 'Composition', 'data' => $notes->pluck('comp')->map(fn ($v) => round((float) $v, 2))->all()],
                    ], 'bar', 2, 'note'),
            ])),
        ];
    }

    public function apprenant(User $user): array
    {
        $this->anneeId = null;

        $evals = DB::table('evaluations as e')
            ->join('matieres as m', 'm.id', '=', 'e.matiere_id')
            ->where('e.inscription_id', $user->inscription_id);

        $semestre = (clone $evals)->where('e.semestre', '!=', '')->max('e.semestre');
        $notes = (clone $evals)
            ->when($semestre, fn ($q) => $q->where('e.semestre', $semestre))
            ->select('m.nom', 'e.note_cc', 'e.note_composition')
            ->orderBy('m.nom')->get();

        $abs = DB::table('absences')->where('inscription_id', $user->inscription_id)
            ->selectRaw('COALESCE(SUM(nombre_heure_absence),0) as absences, COALESCE(SUM(nombre_heure_retard),0) as retards')
            ->first();

        $moy = fn ($col) => $notes->whereNotNull($col)->isEmpty() ? '—'
            : round($notes->whereNotNull($col)->avg($col), 2) . ' / 20';

        return [
            'type' => 'apprenant',
            'titre' => 'Mon suivi pédagogique',
            'sous_titre' => $semestre ? 'Notes du semestre ' . $semestre : 'Aucune note enregistrée pour le moment',
            'annee_id' => null,
            'annees' => [],
            'kpis' => [
                $this->kpi('Matières évaluées', $notes->count(), 'book', 'orange'),
                $this->kpi('Moyenne contrôle continu', $moy('note_cc'), 'chart', 'green'),
                $this->kpi('Moyenne composition', $moy('note_composition'), 'chart', 'orange'),
                $this->kpi('Heures d\'absence', (int) $abs->absences, 'clock', 'green'),
            ],
            'charts' => array_values(array_filter([
                $notes->isEmpty() ? null : $this->bar('notes', 'Mes notes par matière (sur 20)',
                    $notes->pluck('nom')->all(),
                    [
                        ['label' => 'Contrôle continu', 'data' => $notes->pluck('note_cc')->map(fn ($v) => $v === null ? null : (float) $v)->all()],
                        ['label' => 'Composition', 'data' => $notes->pluck('note_composition')->map(fn ($v) => $v === null ? null : (float) $v)->all()],
                    ], 'bar', 2, 'note'),
                ($abs->absences + $abs->retards) > 0 ? $this->donut('assiduite', 'Absences et retards (heures)', [
                    'labels' => ['Absences', 'Retards'],
                    'data' => [(int) $abs->absences, (int) $abs->retards],
                ]) : null,
            ])),
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Requêtes de base                                                   */
    /* ------------------------------------------------------------------ */

    /**
     * Une seule requête ramène, pour l'année choisie, toutes les dimensions
     * nécessaires aux graphiques (sexe, classe, établissement, zone, filière,
     * secteur). Les regroupements se font ensuite en PHP : cela évite de
     * rejouer la même jointure à 8 tables pour chaque graphique.
     *
     * @return Collection<int, object>
     */
    private function lignes(): Collection
    {
        return $this->lignes ??= DB::table('inscriptions as i')
            ->join('apprenants as a', 'a.id', '=', 'i.apprenant_id')
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            ->join('etablissements as e', 'e.id', '=', 'c.etablissement_id')
            ->leftJoin('communes as co', 'co.id', '=', 'e.commune_id')
            ->leftJoin('departements as d', 'd.id', '=', 'co.departement_id')
            ->leftJoin('regions as r', 'r.id', '=', 'd.region_id')
            ->leftJoin('niveau_etudes as n', 'n.id', '=', 'c.niveau_etude_id')
            ->leftJoin('metiers as m', 'm.id', '=', 'n.metier_id')
            ->leftJoin('filieres as f', 'f.id', '=', 'm.filiere_id')
            ->leftJoin('secteurs as s', 's.id', '=', 'f.secteur_id')
            ->where('a.isDeleted', 0)
            ->where('i.annee_academique_id', $this->anneeId)
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('c.etablissement_id', $this->etabIds ?: [0]))
            ->get([
                'i.apprenant_id', 'a.sexe', 'c.id as classe_id', 'c.libelle as classe', 'c.niveau_etude_id as niveau_id', 'c.modalite as modalite',
                'e.id as etab_id', 'e.sigle as etab_sigle', 'e.nom as etab_nom', 'e.type as etab_type',
                'd.id as dept_id', 'd.libelle as dept', 'r.id as region_id', 'r.libelle as region',
                'm.id as metier_id', 'm.nom as metier', 'f.id as filiere_id', 'f.nom as filiere', 's.id as secteur_id', 's.libelle as secteur',
            ]);
    }

    /**
     * Effectif distinct d'apprenants par valeur d'une dimension.
     * $par renvoie [id, libellé] (ou null pour ignorer la ligne).
     *
     * @return array<int, array{0: string, 1: int}> [libellé, effectif] trié décroissant
     */
    private function effectifPar(callable $par, int $limite = 10): array
    {
        $groupes = [];
        foreach ($this->lignes() as $l) {
            if (($cle = $par($l)) === null || $cle[0] === null) {
                continue;
            }
            $groupes[$cle[0]]['libelle'] = $cle[1];
            $groupes[$cle[0]]['ids'][$l->apprenant_id] = true;
        }
        $res = array_map(fn ($g) => [$g['libelle'], count($g['ids'])], $groupes);
        usort($res, fn ($x, $y) => $y[1] <=> $x[1]);

        return array_slice($res, 0, $limite);
    }

    /** Graphique en barres à une série à partir de effectifPar(). */
    private function barEffectif(string $id, string $titre, array $serie, string $type = 'hbar', int $span = 1): ?array
    {
        return $this->bar($id, $titre, array_column($serie, 0),
            [['label' => 'Apprenants', 'data' => array_column($serie, 1)]], $type, $span);
    }

    /** Apprenants distincts par année académique (une seule requête, réutilisée). */
    private function volumesParAnnee(): array
    {
        return $this->volumes ??= DB::table('inscriptions as i')
            ->join('apprenants as a', 'a.id', '=', 'i.apprenant_id')
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('c.etablissement_id', $this->etabIds ?: [0]))
            ->where('a.isDeleted', 0)
            ->groupBy('i.annee_academique_id')
            ->select('i.annee_academique_id as annee', DB::raw('COUNT(DISTINCT i.apprenant_id) as total'))
            ->pluck('total', 'annee')->map(fn ($v) => (int) $v)->all();
    }

    /** Établissements qui ont au moins un inscrit sur l'année choisie. */
    private function etablissementsCount(): int
    {
        return $this->lignes()->pluck('etab_id')->unique()->count();
    }

    private function apprenantsCount(): int
    {
        return $this->lignes()->pluck('apprenant_id')->unique()->count();
    }

    private function classesCount(): int
    {
        return $this->lignes()->pluck('classe_id')->unique()->count();
    }

    private function filieresCount(): int
    {
        return $this->lignes()->pluck('filiere_id')->filter()->unique()->count();
    }

    /**
     * Date de fin de l'année choisie. Le personnel et les comptes n'ont pas de
     * rattachement à une année : on retient ceux créés au plus tard à cette date
     * (effectif cumulé à la fin de l'année). Null = pas de plafond.
     */
    private function finAnnee(): ?string
    {
        return $this->anneeId
            ? DB::table('annee_academiques')->where('id', $this->anneeId)->value('dateFin')
            : null;
    }

    private function personnelCount(): int
    {
        $fin = $this->finAnnee();

        return DB::table('personnel_etablissements as p')
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('p.etablissement_id', $this->etabIds ?: [0]))
            ->when($fin, fn ($q) => $q->whereDate('p.created_at', '<=', $fin))
            ->distinct()->count('p.user_id');
    }

    /**
     * Année demandée si valide, sinon la plus récente ayant une activité
     * significative (≥ 20 % du volume de la plus chargée) : une année tout
     * juste ouverte avec quelques inscriptions ne doit pas vider le tableau.
     */
    private function resolveAnnee(?int $demande, ?array $volumes = null): ?int
    {
        $volumes ??= $this->volumesParAnnee();

        if ($demande && isset($volumes[$demande])) {
            return $demande;
        }
        if (!$volumes) {
            return AnneeDesNotes::anneeParDefaut() ?? DB::table('annee_academiques')->where('is_open', 1)->orderByDesc('id')->value('id');
        }

        krsort($volumes);
        $max = max($volumes);
        foreach ($volumes as $annee => $total) {
            if ($total >= 0.2 * $max) {
                return (int) $annee;
            }
        }

        return (int) array_key_first($volumes);
    }

    private function annees(): array
    {
        return $this->anneesList(array_keys($this->volumesParAnnee()));
    }

    private function anneesList(array $ids): array
    {
        return AnneeAcademique::whereIn('id', $ids)->orderByDesc('id')->get(['id', 'code'])
            ->map(fn ($a) => ['id' => $a->id, 'code' => $a->code])->all();
    }

    /** Années où le formateur a des affectations (matières PPO ou compétences APC), avec leur nombre. */
    private function anneesFormateur(User $user): array
    {
        $total = [];
        foreach (['classe_formateur_matiere', 'classe_formateur_competence'] as $table) {
            foreach (DB::table($table)->where('formateur_id', $user->id)->groupBy('annee_academique_id')
                ->select('annee_academique_id as annee', DB::raw('COUNT(*) as total'))->pluck('total', 'annee') as $annee => $n) {
                $total[$annee] = ($total[$annee] ?? 0) + $n;
            }
        }

        return $total;
    }

    /* ------------------------------------------------------------------ */
    /*  Graphiques                                                         */
    /* ------------------------------------------------------------------ */

    private function chartSexe(): ?array
    {
        $rows = collect($this->effectifPar(fn ($l) => [$l->sexe ?? '', $l->sexe ?? ''], 10))
            ->map(fn ($r) => (object) ['sexe' => $r[0], 'total' => $r[1]]);

        return $this->donut('sexe', 'Répartition des apprenants par sexe', $this->sexeSeries($rows));
    }

    private function sexeSeries($rows): array
    {
        $labels = ['F' => 'Filles', 'M' => 'Garçons'];
        $data = [];
        foreach ($labels as $code => $label) {
            $data[$label] = (int) ($rows->firstWhere('sexe', $code)->total ?? 0);
        }
        $autres = $rows->whereNotIn('sexe', array_keys($labels))->sum('total');
        if ($autres > 0) {
            $data['Non renseigné'] = (int) $autres;
        }

        return ['labels' => array_keys($data), 'data' => array_values($data)];
    }

    /** Effectifs de toutes les années (non filtré) pour voir la tendance. */
    private function chartEvolutionInscriptions(): ?array
    {
        $volumes = $this->volumesParAnnee();
        if (count($volumes) < 2) {
            return null;
        }

        $codes = AnneeAcademique::whereIn('id', array_keys($volumes))->orderBy('code')->pluck('code', 'id');

        return $this->bar('evolution', 'Évolution des effectifs par année académique',
            $codes->values()->all(),
            [['label' => 'Apprenants', 'data' => $codes->keys()->map(fn ($id) => $volumes[$id])->all()]]);
    }

    private function chartParZone(string $niveau): ?array
    {
        $region = $niveau === 'region';
        $serie = $this->effectifPar($region
            ? fn ($l) => [$l->region_id, $l->region]
            : fn ($l) => [$l->dept_id, $l->dept], 15);

        return $this->barEffectif('zone', $region ? 'Apprenants par région' : 'Apprenants par département', $serie);
    }

    private function chartTypesEtablissement(): ?array
    {
        $types = [];
        foreach ($this->lignes() as $l) {
            $types[$l->etab_type ?: 'Non renseigné'][$l->etab_id] = true;
        }
        $types = array_map('count', $types);
        arsort($types);

        return $this->donut('types', 'Établissements par type', [
            'labels' => array_keys($types),
            'data' => array_values($types),
        ]);
    }

    private function chartTopEtablissements(): ?array
    {
        return $this->barEffectif('top-etab', 'Top 10 des établissements par effectif',
            $this->effectifPar(fn ($l) => [$l->etab_id, $l->etab_sigle ?: $l->etab_nom]));
    }

    private function chartParSecteur(): ?array
    {
        return $this->barEffectif('secteurs', 'Apprenants par secteur de formation',
            $this->effectifPar(fn ($l) => [$l->secteur_id, $l->secteur]));
    }

    /** Tous les métiers, affichés par pages de 15 côté navigateur. */
    private function chartParMetier(): ?array
    {
        $chart = $this->barEffectif('metiers', 'Apprenants par métier',
            $this->effectifPar(fn ($l) => [$l->metier_id, $l->metier], PHP_INT_MAX), 'hbar', 2);

        return $chart ? $chart + ['par_page' => 15] : null;
    }

    private function chartParFiliere(): ?array
    {
        return $this->barEffectif('filieres', 'Apprenants par filière',
            $this->effectifPar(fn ($l) => [$l->filiere_id, $l->filiere]));
    }

    private function chartEffectifParClasse(): ?array
    {
        return $this->barEffectif('classes', 'Effectif par classe',
            $this->effectifPar(fn ($l) => [$l->classe_id, $l->classe], 12));
    }

    /**
     * Moyenne générale de chaque inscription par semestre, calculée comme dans
     * les bulletins : moyenne matière = (CC + composition) / 2, moyenne du
     * semestre = Σ(moyenne × coef) / Σ coef (matières à coef > 0 ayant les deux notes).
     */
    private function moyennes(): Collection
    {
        if ($this->moyennes !== null) {
            return $this->moyennes;
        }

        $lignes = collect();

        // 1) Inscriptions valides : moyenne pondérée du semestre calculée en SQL.
        $reelles = DB::table('evaluations as ev')
            ->join('inscriptions as i', 'i.id', '=', 'ev.inscription_id')
            ->join('apprenants as a', 'a.id', '=', 'i.apprenant_id')
            ->join('matieres as m', 'm.id', '=', 'ev.matiere_id')
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            ->leftJoin('niveau_etudes as n', 'n.id', '=', 'c.niveau_etude_id')
            ->leftJoin('metiers as mt', 'mt.id', '=', 'n.metier_id')
            ->leftJoin('filieres as f', 'f.id', '=', 'mt.filiere_id')
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('c.etablissement_id', $this->etabIds ?: [0]))
            ->where('a.isDeleted', 0)
            ->whereIn('ev.semestre', ['1', '2'])
            ->where('m.coef', '>', 0)
            ->whereNotNull('ev.note_cc')->whereNotNull('ev.note_composition')
            ->groupBy('ev.inscription_id', 'ev.semestre', 'c.id', 'c.libelle', 'f.id', 'f.nom')
            ->select('ev.inscription_id', 'ev.semestre',
                'c.id as classe_id', 'c.libelle as classe', 'f.id as filiere_id', 'f.nom as filiere',
                DB::raw('SUM((ev.note_cc + ev.note_composition) / 2 * m.coef) / SUM(m.coef) as moy'));

        if (!AnneeDesNotes::restreindre($reelles, 'evaluations', 'ev', $this->anneeId)) {
            return $this->moyennes = collect();   // aucune note pour cette année
        }
        $lignes = $lignes->concat($reelles->get());

        // 2) Notes orphelines (inscription supprimée) : classe déduite des devoirs, agrégat en PHP.
        $classeDe = InscriptionClasses::orphelines();
        if ($classeDe) {
            $classes = DB::table('classes as c')
                ->leftJoin('niveau_etudes as n', 'n.id', '=', 'c.niveau_etude_id')
                ->leftJoin('metiers as mt', 'mt.id', '=', 'n.metier_id')
                ->leftJoin('filieres as f', 'f.id', '=', 'mt.filiere_id')
                ->when($this->etabIds !== null, fn ($q) => $q->whereIn('c.etablissement_id', $this->etabIds ?: [0]))
                ->get(['c.id', 'c.libelle', 'f.id as filiere_id', 'f.nom as filiere'])->keyBy('id');

            $orphelines = DB::table('evaluations as ev')
                ->join('matieres as m', 'm.id', '=', 'ev.matiere_id')
                ->whereNotExists(InscriptionClasses::valide('ev.inscription_id'))
                ->whereIn('ev.semestre', ['1', '2'])
                ->where('m.coef', '>', 0)
                ->whereNotNull('ev.note_cc')->whereNotNull('ev.note_composition')
                ->select('ev.inscription_id', 'ev.semestre', 'ev.note_cc', 'ev.note_composition', 'm.coef');
            AnneeDesNotes::restreindre($orphelines, 'evaluations', 'ev', $this->anneeId);

            $totaux = [];   // "inscription|semestre" => [classe, Σ moyenne×coef, Σ coef]
            foreach ($orphelines->cursor() as $n) {
                $classe = $classeDe[$n->inscription_id] ?? null;
                if ($classe === null || !isset($classes[$classe])) {
                    continue;   // classe inconnue ou hors du périmètre
                }
                $cle = $n->inscription_id . '|' . $n->semestre;
                $totaux[$cle] ??= ['inscription_id' => $n->inscription_id, 'semestre' => $n->semestre, 'classe' => $classe, 'somme' => 0.0, 'coef' => 0.0];
                $totaux[$cle]['somme'] += ($n->note_cc + $n->note_composition) / 2 * $n->coef;
                $totaux[$cle]['coef'] += $n->coef;
            }

            $lignes = $lignes->concat(collect($totaux)->map(fn ($t) => (object) [
                'inscription_id' => $t['inscription_id'],
                'semestre' => $t['semestre'],
                'classe_id' => $t['classe'],
                'classe' => $classes[$t['classe']]->libelle,
                'filiere_id' => $classes[$t['classe']]->filiere_id,
                'filiere' => $classes[$t['classe']]->filiere,
                'moy' => $t['somme'] / $t['coef'],
            ]));
        }

        return $this->moyennes = $lignes->values();
    }

    /** Avancement de la saisie des devoirs et des compositions par établissement (voir SaisieNotes). */
    private function saisieNotes(): ?array
    {
        $classes = [];   // classe_id => [etab, niveau, modalite, inscrits]
        $noms = [];
        foreach ($this->lignes() as $l) {
            $classes[$l->classe_id] ??= ['etab' => $l->etab_id, 'niveau' => $l->niveau_id, 'modalite' => $l->modalite, 'n' => 0];
            $classes[$l->classe_id]['n']++;
            $noms[$l->etab_id] ??= $l->etab_sigle ? $l->etab_sigle . ' — ' . $l->etab_nom : $l->etab_nom;
        }

        return (new SaisieNotes($this->anneeId, $classes, $noms))->calculer();
    }

    /** Répartition des apprenants par mention (mêmes tranches que les bulletins), par semestre. */
    private function chartMentions(): ?array
    {
        $tranches = [['Insuffisant', '< 10'], ['Passable', '10 – 12'], ['Assez bien', '12 – 14'],
            ['Bien', '14 – 16'], ['Bon travail', '16 – 18'], ['Très bon travail', '≥ 18']];
        $rang = fn ($m) => $m < 10 ? 0 : ($m < 12 ? 1 : ($m < 14 ? 2 : ($m < 16 ? 3 : ($m < 18 ? 4 : 5))));

        $inscrits = $this->lignes()->count();
        $datasets = [];
        foreach ($this->moyennes()->groupBy('semestre')->sortKeys() as $semestre => $lignes) {
            $n = $lignes->count();
            if ($n < self::MIN_EVALUES) {
                continue;   // un semestre à peine entamé ne donne pas de répartition significative
            }
            $effectifs = array_fill(0, 6, 0);
            foreach ($lignes as $l) {
                $effectifs[$rang((float) $l->moy)]++;
            }
            $reussite = round(100 * $lignes->filter(fn ($l) => $l->moy >= 10)->count() / $n);
            $datasets[] = [
                'label' => "Semestre $semestre · " . number_format($n, 0, ',', ' ') . ' évalués sur ' . number_format($inscrits, 0, ',', ' ') . " inscrits · $reussite % de réussite",
                'data' => array_map(fn ($e) => round(100 * $e / $n, 1), $effectifs),
                'counts' => $effectifs,
            ];
        }

        if (!$datasets) {
            return null;
        }

        // 'legende' : la légende porte l'effectif évalué et le taux de réussite, même avec un seul semestre.
        return $this->bar('mentions', 'Répartition des apprenants par moyenne du semestre',
            array_map(fn ($t) => [$t[0], $t[1]], $tranches), $datasets, 'bar', 1, 'pct') + ['legende' => true];
    }

    /** Taux de réussite (moyenne du semestre ≥ 10) par filière ou par classe, pour le semestre le plus renseigné. */
    private function chartReussite(string $par): ?array
    {
        $parSemestre = $this->moyennes()->groupBy('semestre')->filter(fn ($l) => $l->count() >= self::MIN_EVALUES);
        if ($parSemestre->isEmpty()) {
            return null;
        }
        $semestre = $parSemestre->sortByDesc(fn ($l) => $l->count())->keys()->first();

        $cle = $par === 'classe' ? 'classe_id' : 'filiere_id';
        $nom = $par === 'classe' ? 'classe' : 'filiere';
        $minimum = $par === 'classe' ? 5 : 10;   // en dessous, le taux n'est pas représentatif

        $groupes = $parSemestre[$semestre]->filter(fn ($l) => $l->$cle !== null)->groupBy($cle)
            ->filter(fn ($g) => $g->count() >= $minimum)
            ->map(fn ($g) => [
                'nom' => $g->first()->$nom,
                'taux' => round(100 * $g->filter(fn ($l) => $l->moy >= 10)->count() / $g->count(), 1),
                'n' => $g->count(),
            ])->sortByDesc('taux')->values();

        if ($groupes->isEmpty()) {
            return null;
        }

        $chart = $this->bar('reussite', 'Taux de réussite par ' . ($par === 'classe' ? 'classe' : 'filière')
            . " — semestre $semestre (moyenne ≥ 10, au moins $minimum évalués)",
            $groupes->pluck('nom')->all(),
            [['label' => 'Taux de réussite', 'data' => $groupes->pluck('taux')->all(), 'counts' => $groupes->pluck('n')->all()]],
            'hbar', 2, 'pct');

        return $chart ? $chart + ['par_page' => 10] : null;
    }

    /** Absences de l'année dans le périmètre (jointures inscription et classe). */
    private function absencesBase(): Builder
    {
        return DB::table('absences as ab')
            ->join('inscriptions as i', 'i.id', '=', 'ab.inscription_id')
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            // Année propre de l'absence (colonne ajoutée par la migration) ; à défaut, celle de l'inscription.
            ->when(AnneeDesNotes::aUneColonne('absences'),
                fn ($q) => $q->where('ab.annee_academique_id', $this->anneeId),
                fn ($q) => $q->where('i.annee_academique_id', $this->anneeId))
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('c.etablissement_id', $this->etabIds ?: [0]));
    }

    private function chartAbsences(): ?array
    {
        $rows = $this->absencesBase()
            ->groupBy('ab.semestre')
            ->select('ab.semestre',
                DB::raw('COALESCE(SUM(ab.nombre_heure_absence),0) as absences'),
                DB::raw('COALESCE(SUM(ab.nombre_heure_retard),0) as retards'))
            ->orderBy('ab.semestre')->get();

        if ($rows->isEmpty()) {
            return null;
        }

        return $this->bar('absences', 'Absences et retards par semestre (heures)',
            $rows->map(fn ($r) => 'Semestre ' . $r->semestre)->all(),
            [
                ['label' => 'Absences', 'data' => $rows->pluck('absences')->map(fn ($v) => (int) $v)->all()],
                ['label' => 'Retards', 'data' => $rows->pluck('retards')->map(fn ($v) => (int) $v)->all()],
            ]);
    }

    /** Heures d'absence et de retard par classe, classes les plus touchées en premier. */
    private function chartAbsencesParClasse(): ?array
    {
        $rows = $this->absencesBase()
            ->groupBy('c.id', 'c.libelle')
            ->select('c.libelle',
                DB::raw('COALESCE(SUM(ab.nombre_heure_absence),0) as absences'),
                DB::raw('COALESCE(SUM(ab.nombre_heure_retard),0) as retards'))
            ->orderByRaw('COALESCE(SUM(ab.nombre_heure_absence),0) + COALESCE(SUM(ab.nombre_heure_retard),0) DESC')
            ->get();

        if ($rows->isEmpty()) {
            return null;
        }

        $chart = $this->bar('absences-classes', 'Absences et retards par classe (heures)',
            $rows->pluck('libelle')->all(),
            [
                ['label' => 'Absences', 'data' => $rows->pluck('absences')->map(fn ($v) => (int) $v)->all()],
                ['label' => 'Retards', 'data' => $rows->pluck('retards')->map(fn ($v) => (int) $v)->all()],
            ], 'hbar', 2);

        return $chart ? $chart + ['par_page' => 10] : null;
    }

    private function chartPersonnelParProfil(): ?array
    {
        $rows = DB::table('personnel_etablissements as p')
            ->join('model_has_roles as mr', function ($j) {
                $j->on('mr.model_id', '=', 'p.user_id')->where('mr.model_type', User::class);
            })
            ->join('roles as r', 'r.id', '=', 'mr.role_id')
            ->when($this->etabIds !== null, fn ($q) => $q->whereIn('p.etablissement_id', $this->etabIds ?: [0]))
            ->when($this->finAnnee(), fn ($q, $fin) => $q->whereDate('p.created_at', '<=', $fin))
            ->groupBy('r.name')
            ->select('r.name', DB::raw('COUNT(DISTINCT p.user_id) as total'))
            ->orderByDesc('total')->get();

        return $this->bar('personnel', 'Personnel par profil', $rows->map(fn ($r) => $this->libelleRole($r->name))->all(),
            [['label' => 'Personnel', 'data' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all()]], 'hbar');
    }

    /** Les apprenants sont exclus : ils écraseraient les autres profils. */
    private function chartUtilisateursParProfil(): ?array
    {
        $rows = DB::table('model_has_roles as mr')
            ->join('roles as r', 'r.id', '=', 'mr.role_id')
            ->join('users as u', 'u.id', '=', 'mr.model_id')
            ->where('mr.model_type', User::class)
            ->where('r.name', '!=', 'apprenant')
            ->when($this->finAnnee(), fn ($q, $fin) => $q->whereDate('u.created_at', '<=', $fin))
            ->groupBy('r.name')
            ->select('r.name', DB::raw('COUNT(*) as total'))
            ->orderByDesc('total')->limit(12)->get();

        return $this->bar('profils', 'Comptes utilisateurs par profil (hors apprenants)',
            $rows->map(fn ($r) => $this->libelleRole($r->name))->all(),
            [['label' => 'Utilisateurs', 'data' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all()]], 'hbar');
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers de structure                                               */
    /* ------------------------------------------------------------------ */

    private function libelleRole(string $role): string
    {
        return ucfirst(str_replace('_', ' ', $role));
    }

    private function kpi(string $label, $valeur, string $icone, string $couleur, ?string $modal = null, ?string $modalTitre = null, bool $listeGlobale = false): array
    {
        return [
            'label' => $label,
            'valeur' => is_numeric($valeur) ? number_format($valeur, 0, ',', ' ') : $valeur,
            'icone' => $icone,
            'couleur' => $couleur,
            'modal' => $modal ? ['component' => $modal, 'titre' => $modalTitre ?? $label, 'globale' => $listeGlobale] : null,
        ];
    }

    private function donut(string $id, string $titre, array $serie): ?array
    {
        if (array_sum($serie['data']) === 0) {
            return null;
        }

        return [
            'id' => $id, 'titre' => $titre, 'type' => 'doughnut', 'span' => 1, 'format' => 'int',
            'labels' => $serie['labels'],
            'datasets' => [['label' => $titre, 'data' => $serie['data']]],
        ];
    }

    private function bar(string $id, string $titre, array $labels, array $datasets, string $type = 'bar', int $span = 1, string $format = 'int'): ?array
    {
        if (!$labels) {
            return null;
        }

        return compact('id', 'titre', 'type', 'span', 'format', 'labels', 'datasets');
    }
}
