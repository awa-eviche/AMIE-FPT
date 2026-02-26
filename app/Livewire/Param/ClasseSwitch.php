<?php

namespace App\Livewire\Param;
use App\Models\Classe;
use App\Models\Competence;
use App\Models\DevoirAPC;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
class ClasseSwitch extends Component
{
    public $classe;
    public $classes = [];
    public $apprenants = [];
    public $annee_academique_id;
    public $anneeAcademiques;
    public $anneeAcademiqueLabel;

    public $currentClasse = null;
    public $currentApprenant = null;
    public $selectedApprenant;
    public $selectedsemestre1 = '';

    public $competences = [];
    public $evaluations = [];

    public $filtres = [];
    public $filtre = null;

    public $count = 0;
    public $startLimit = 0;
    public $nombreApprenants = 0;

   
    public $showApcClasseModal = false;
    public $apcSemestre = '';

    public $apprenantsApcModal = [];
    public $mccsApc = [];           
    public $compositionsApc = [];   
    public $acquisApc = [];         

    public $competencesGenerales = [];
    public $competencesParticulieres = [];
    public $showAbsenceClasseModal = false;
    public $apprenantsAbsModal = [];

public $showNotesModal = false;

public $notesApprenantId = ''; // ✅ filtre apprenant (inscription_id)

public $notesCompetenceType = '';
public $notesCompetenceName = '';
public $notesCompetenceOptions = [];
public $notesCompetenceFilter = null;





  // liste dynamique des noms

#[On('open-absence-classe')]
public function openAbsenceClasseModal()
{
    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    $this->apprenantsAbsModal = Inscription::with('apprenant')
        ->where('classe_id', $this->classe)
        ->where('annee_academique_id', $this->annee_academique_id)
        ->orderBy('id')
        ->get(); 

    $this->showAbsenceClasseModal = true;
}

public function closeAbsenceClasseModal()
{
    $this->showAbsenceClasseModal = false;
}

public function openNotesModal()
{
    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    $this->apcSemestre = $this->apcSemestre ?: session()->get('selectedsemestre1');
    if (!$this->apcSemestre) {
        session()->flash('error', 'Veuillez sélectionner un semestre.');
        return;
    }

    // ✅ reset filtre apprenant
    $this->notesApprenantId = '';

    // 1) Apprenants
    $this->apprenantsApcModal = Inscription::with('apprenant')
        ->where('classe_id', $this->classe)
        ->where('annee_academique_id', $this->annee_academique_id)
        ->orderBy('id')
        ->get();

    $niveauId = Classe::whereKey($this->classe)->value('niveau_etude_id');
    $user = auth()->user();

    // 2) Compétences (formateur => uniquement ses compétences / non-formateur => toutes)
 $classeId = $this->classe;

$competencesQuery = Competence::query()
    ->where('niveau_etude_id', $niveauId)
    ->with(['ressources' => function ($q) use ($classeId) {
        $q->where('classe_id', $classeId);
    }]);



    if ($user && $user->hasRole('formateur')) {
        $competenceIds = DB::table('classe_formateur_competence')
            ->where('classe_id', $this->classe)
            ->where('formateur_id', $user->id)
            ->pluck('competence_id')
            ->toArray();

        if (empty($competenceIds)) {
            session()->flash('error', 'Aucune compétence ne vous est assignée dans cette classe.');
            return;
        }

        $competencesQuery->whereIn('id', $competenceIds);
    }

    $competences = $competencesQuery->get();

    $this->competencesGenerales = $competences->where('type', 'generale')->values();
    $this->competencesParticulieres = $competences->where('type', 'particuliere')->values();

    // ✅ charge les notes (tes fonctions existantes)
    $this->loadApcMccAndCompositions();

    $this->showNotesModal = true;
}

public function closeNotesModal()
{
    $this->showNotesModal = false;

    // ✅ reset filtre
    $this->notesApprenantId = '';
    // dans openNotesModal()


}




private function buildApcDisciplines(): void
{
    $build = function ($competences) {
        $map = [];

        foreach ($competences as $comp) {
            foreach (($comp->ressources ?? collect()) as $res) {
                $rid = (int) $res->id;

                if (!isset($map[$rid])) {
                    $map[$rid] = [
                        'ressource_id'    => $rid,
                        'discipline'      => (string) $res->nom,
                        'competence_ids'  => [],
                        'competence_noms' => [],
                    ];
                }

                $cid = (int) $comp->id;
                if (!in_array($cid, $map[$rid]['competence_ids'], true)) {
                    $map[$rid]['competence_ids'][]  = $cid;
                    $map[$rid]['competence_noms'][] = (string) $comp->nom;
                }
            }
        }

        $items = array_values($map);
        usort($items, fn($a, $b) => strcmp($a['discipline'], $b['discipline']));
        return $items;
    };

    $this->apcDisciplinesGenerales     = $build($this->competencesGenerales);
    $this->apcDisciplinesParticulieres = $build($this->competencesParticulieres);
}

public function updatedNotesApprenantId()
{
    $this->notesCompetenceName = '';
    $this->rebuildNotesCompetenceOptions();
}

public function updatedNotesCompetenceType()
{
    $this->notesCompetenceName = '';
    $this->rebuildNotesCompetenceOptions();
}

private function rebuildNotesCompetenceOptions(): void
{
    $iid  = $this->notesApprenantId ? (int) $this->notesApprenantId : 0;
    $type = $this->notesCompetenceType ? trim((string) $this->notesCompetenceType) : '';

    $this->notesCompetenceOptions = [];

    if (!$iid || !in_array($type, ['generale', 'particuliere'], true)) {
        return;
    }

    $competences = ($type === 'generale')
        ? ($this->competencesGenerales ?? collect())
        : ($this->competencesParticulieres ?? collect());

    $iidKey = (string)$iid;
    $names = [];

    foreach ($competences as $comp) {
        $compNom = trim((string) ($comp->nom ?? ''));
        if ($compNom === '') continue;

        $hasNote = false;

        foreach (($comp->ressources ?? collect()) as $res) {
            $rid = (int) ($res->id ?? 0);
            if (!$rid) continue;

            $ridKey = (string)$rid;

            $mcc = $this->mccsApc[$iidKey][$ridKey] ?? null;
            $compOrInt = $this->compositionsApc[$iidKey][$ridKey] ?? null;

            if (is_numeric($mcc) || is_numeric($compOrInt)) {
                $hasNote = true;
                break;
            }
        }

        if ($hasNote) $names[] = $compNom;
    }

    $names = array_values(array_unique($names));
    sort($names, SORT_NATURAL | SORT_FLAG_CASE);

    $this->notesCompetenceOptions = $names;
}


    public function mount()
    {
        $user = auth()->user();

        $this->anneeAcademiques = AnneeAcademique::all();
        $this->annee_academique_id = session()->get('annee_academique_id', '');

        $this->anneeAcademiqueLabel = optional(
            $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)
        )->code;

        if ($user->hasRole('formateur') && $user->personnel) {
            $this->classes = Classe::where('modalite', 'APC')
                ->whereHas('formateurs', function ($q) use ($user) {
                    $q->where('personnel_etablissement_id', $user->personnel->id);
                })->get();
        } elseif ($user->hasRole('superadmin')) {
            $this->classes = Classe::where('modalite', 'APC')->get();
        } else {
            $etabId = $user->personnel->etablissement_id ?? null;
            $this->classes = Classe::where('modalite', 'APC')
                ->when($etabId, fn($q) => $q->where('etablissement_id', $etabId))
                ->get();
        }

        
        if ($this->classe && $this->annee_academique_id) {
            $this->updatedClasse();
        }
    }

    public function updatedClasse()
    {
        session()->put('currentClasse', $this->classe);

        $this->currentClasse = Classe::with(['etablissement', 'niveau_etude.metier.filiere'])
            ->find($this->classe);

        $this->loadApprenants();
        $this->resetSelection();  
    }

 
    public function updatedAnnee_academique_id()
    {
        session()->put('annee_academique_id', $this->annee_academique_id);

        $this->anneeAcademiqueLabel = optional(
            $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)
        )->code;

        $this->loadApprenants();
        $this->resetSelection();
    }

   public function goEvaluationSomative()
{
    session()->put('evaluation_classe_id', $this->classe);
    session()->put('evaluation_annee_academique_id', $this->annee_academique_id);

    return redirect()->route('evaluation.sommative.page');
}

    public function updatedAnneeAcademiqueId()
    {
        
        $this->updatedAnnee_academique_id();
    }

    public function updatedSelectedsemestre1($semestre)
    {
        session()->put('selectedsemestre1', $semestre);

        if ($this->selectedApprenant) {
            $this->loadCompetences($this->selectedApprenant);
        }

        $this->loadEvaluations();
    }

    private function resetSelection()
    {
        $this->selectedApprenant = null;
        $this->currentApprenant = null;
        $this->competences = [];
        $this->evaluations = [];
        $this->filtres = [];
        $this->filtre = null;
        $this->count = 0;
        $this->startLimit = 0;
    }

    public function loadApprenants()
    {
        if (!$this->classe || !$this->annee_academique_id) {
            $this->apprenants = [];
            $this->nombreApprenants = 0;
            return;
        }

        $this->apprenants = Inscription::with('apprenant')
            ->where('classe_id', $this->classe)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->get();

        $this->nombreApprenants = $this->apprenants->count();
    }

 public function loadCompetences($inscriptionId)
{
    $this->selectedApprenant = $inscriptionId;
    $this->currentApprenant = Inscription::with(['apprenant', 'classe'])->find($inscriptionId);
    if (!$this->currentApprenant) return;

    $user  = auth()->user();
    $classe = $this->currentApprenant->classe;

    $competenceIds = [];

    if ($user->hasRole('formateur')) {
        $competenceIds = DB::table('classe_formateur_competence')
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $user->id)
            ->pluck('competence_id')
            ->toArray();

        if (empty($competenceIds)) {
            $this->competences = collect();
            $this->filtres = collect();
            $this->evaluations = [];
            return;
        }
    }
$query = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
    ->with(['ressources' => function ($q) use ($classe) {
        $q->where('classe_id', $classe->id);
    }]);


    if ($user->hasRole('formateur')) {
        $query->whereIn('id', $competenceIds);
    }

    $this->competences = $query->get();

    if ($this->filtre) {
        $this->competences = $this->competences->where('id', $this->filtre);
    }

    $this->filtres = $this->competences;

    $this->loadEvaluations();
}


   public function loadEvaluations()
{
    if (!$this->selectedApprenant || empty($this->selectedsemestre1)) {
        $this->evaluations = [];
        return;
    }

    $semestre = (int) $this->selectedsemestre1;

   
    $ressourceIds = collect($this->competences)
        ->flatMap(fn($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()
        ->unique()
        ->values()
        ->all();

    if (empty($ressourceIds)) {
        $this->evaluations = [];
        return;
    }

    $evals = Evalute::query()
        ->where('inscription_id', (int) $this->selectedApprenant)
        ->where('semestre', $semestre)
        ->whereIn('ressource_id', $ressourceIds)
        ->get(['ressource_id', 'composition']);

    $map = [];
    foreach ($evals as $e) {
        $map[$e->ressource_id] = [
            'composition' => $e->composition !== null ? (float) $e->composition : null,
            'mcc' => 0.0,
        ];
    }

    // 2) ✅ MCC = moyenne des notes (devoir_apcs)
    $mccRows = DevoirAPC::query()
        
        ->where('semestre', $semestre)
        ->where('inscription_id', (int) $this->selectedApprenant)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note')
        ->selectRaw('ressource_id, ROUND(AVG(note),2) as mcc')
        ->groupBy('ressource_id')
        ->get();

    foreach ($mccRows as $r) {
        if (!isset($map[$r->ressource_id])) {
            $map[$r->ressource_id] = ['composition' => null, 'mcc' => 0.0];
        }
        $map[$r->ressource_id]['mcc'] = (float) $r->mcc;
    }

   
    foreach ($ressourceIds as $rid) {
        if (!isset($map[$rid])) {
            $map[$rid] = ['composition' => null, 'mcc' => 0.0];
        }
    }

    $this->evaluations = $map;
}

    

public function openApcClasseModal()
{
    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    $user = auth()->user();

    // 1) Apprenants
    $this->apprenantsApcModal = Inscription::with('apprenant')
        ->where('classe_id', $this->classe)
        ->where('annee_academique_id', $this->annee_academique_id)
        ->orderBy('id')
        ->get();

    $competenceIds = DB::table('classe_formateur_competence')
        ->where('classe_id', $this->classe)
        ->where('formateur_id', $user->id)
        ->pluck('competence_id')
        ->toArray();

    
    $this->showApcClasseModal = true;

    if (empty($competenceIds)) {
        session()->flash('error', 'Aucune compétence ne vous est assignée dans cette classe.');

        // On vide les collections pour éviter erreurs
        $this->competencesGenerales = collect();
        $this->competencesParticulieres = collect();

        return;
    }

    $classeId = $this->classe;

    $competences = Competence::query()
        ->whereIn('id', $competenceIds)
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId);
        }])
        ->get();

    $this->competencesGenerales = $competences->where('type', 'generale')->values();
    $this->competencesParticulieres = $competences->where('type', 'particuliere')->values();

    $this->mccsApc = [];
    $this->compositionsApc = [];
    $this->acquisApc = [];

    if (!empty($this->apcSemestre)) {
        $this->loadApcMccAndCompositions();
    }
}



    public function closeApcClasseModal()
    {
        $this->showApcClasseModal = false;
    }

  public function updatedApcSemestre($value)
{
    if (!$this->showApcClasseModal && !$this->showNotesModal) return;

    if (!$value) {
        $this->mccsApc = [];
        $this->compositionsApc = [];
        return;
    }
$classeId = $this->classe;
    $user = auth()->user();

    $competenceIds = DB::table('classe_formateur_competence')
        ->where('classe_id', $classeId)
        ->where('formateur_id', $user->id)
        ->pluck('competence_id')
        ->toArray();

    $competences = Competence::query()
        ->whereIn('id', $competenceIds)
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId);
        }])
        ->get();

    $this->competencesGenerales = $competences->where('type', 'generale')->values();
    $this->competencesParticulieres = $competences->where('type', 'particuliere')->values();
    $this->loadApcMccAndCompositions();
}



private function loadApcMccAndCompositions()
{
    if (!$this->apcSemestre) return;

    $inscriptions = collect($this->apprenantsApcModal);

    $inscriptionIds = $inscriptions->pluck('id')->filter()->values()->all();
    $apprenantIds   = $inscriptions->pluck('apprenant_id')->filter()->values()->all();

    $ressourceIds = collect($this->competencesGenerales)
        ->merge($this->competencesParticulieres)
        ->flatMap(function ($c) {
            return ($c->ressources ?? collect())->pluck('id');
        })
        ->filter()
        ->unique()
        ->values()
        ->all();

    // ✅ reset
    $this->mccsApc = [];
    $this->compositionsApc = [];
    $this->acquisApc = [];

    if (empty($inscriptionIds) || empty($ressourceIds)) {
        return;
    }

    $devoirTable = (new DevoirAPC)->getTable();

    $q = DevoirAPC::query()
        ->where('semestre', (int) $this->apcSemestre)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note');

    // classe_id uniquement si la colonne existe
    if (Schema::hasColumn($devoirTable, 'classe_id')) {
        $q->where('classe_id', (int) $this->classe);
    }

    // Certains projets stockent par inscription_id, d'autres par apprenant_id
    if (Schema::hasColumn($devoirTable, 'inscription_id')) {

        $rows = $q->whereIn('inscription_id', $inscriptionIds)
            ->selectRaw('inscription_id, ressource_id, ROUND(AVG(note),2) as mcc')
            ->groupBy('inscription_id', 'ressource_id')
            ->get();

        foreach ($rows as $r) {
            $this->mccsApc[$r->inscription_id][$r->ressource_id] = (float) $r->mcc;
        }

    } elseif (Schema::hasColumn($devoirTable, 'apprenant_id')) {

        $rows = $q->whereIn('apprenant_id', $apprenantIds)
            ->selectRaw('apprenant_id, ressource_id, ROUND(AVG(note),2) as mcc')
            ->groupBy('apprenant_id', 'ressource_id')
            ->get();

        // mapper apprenant_id -> inscription_id pour garder ton Blade inchangé
        $map = $inscriptions->keyBy('apprenant_id');

        foreach ($rows as $r) {
            $insc = $map->get($r->apprenant_id);
            if (!$insc) continue;

            $this->mccsApc[$insc->id][$r->ressource_id] = (float) $r->mcc;
        }
    }

   
    $evalTable = (new Evalute)->getTable();
    $ev = Evalute::query()
    ->where('semestre', (int) $this->apcSemestre)
   
    ->whereIn('inscription_id', $inscriptionIds)
    ->whereIn('ressource_id', $ressourceIds);

$evals = $ev->get(['inscription_id','ressource_id','composition']);

foreach ($evals as $e) {
    $this->compositionsApc[$e->inscription_id][$e->ressource_id] = $e->composition;
}

}

public function saveApcClasse()
{
    if (!auth()->user()->hasRole('formateur')) {
        session()->flash('error', 'Action non autorisée.');
        return;
    }

    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    if (!$this->apcSemestre) {
        session()->flash('error', 'Veuillez sélectionner un semestre.');
        return;
    }

    // Notes possibles (optionnelles)
    $this->validate([
        'compositionsApc' => 'array',
        'compositionsApc.*.*' => 'nullable|numeric|min:0|max:20',
    ]);

    $inscriptionIds = collect($this->apprenantsApcModal)->pluck('id')->filter()->values()->all();

    // Ressources (par type)
    $generalRessourceIds = collect($this->competencesGenerales)
        ->flatMap(fn($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()->unique()->values()->all();

    $particularRessourceIds = collect($this->competencesParticulieres)
        ->flatMap(fn($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()->unique()->values()->all();

    $ressourceIds = collect($generalRessourceIds)->merge($particularRessourceIds)->unique()->values()->all();

    if (empty($inscriptionIds) || empty($ressourceIds)) {
        session()->flash('error', 'Aucune donnée à enregistrer.');
        return;
    }

    $generalSet = array_flip($generalRessourceIds);
    $partSet    = array_flip($particularRessourceIds);

    // ✅ MCC AVG(note)
    $mccRows = DevoirAPC::query()
        
        ->where('semestre', (int)$this->apcSemestre)
        ->whereIn('inscription_id', $inscriptionIds)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note')
        ->selectRaw('inscription_id, ressource_id, ROUND(AVG(note),2) as mcc')
        ->groupBy('inscription_id', 'ressource_id')
        ->get();

    $mccMap = [];
    foreach ($mccRows as $r) {
        $mccMap[$r->inscription_id][$r->ressource_id] = (float)$r->mcc;
    }

    // ✅ dernier devoirapc_id
    $devoirs = DevoirAPC::query()
        
        ->where('semestre', (int)$this->apcSemestre)
        ->whereIn('inscription_id', $inscriptionIds)
        ->whereIn('ressource_id', $ressourceIds)
        ->select('id', 'inscription_id', 'ressource_id')
        ->orderByDesc('id')
        ->get();

    $devoirIdMap = [];
    foreach ($devoirs as $d) {
        if (!isset($devoirIdMap[$d->inscription_id][$d->ressource_id])) {
            $devoirIdMap[$d->inscription_id][$d->ressource_id] = $d->id;
        }
    }

    $existing = Evalute::query()
        ->where('semestre', (int)$this->apcSemestre)
        ->whereIn('inscription_id', $inscriptionIds)
        ->whereIn('ressource_id', $ressourceIds)
        
        ->get(['inscription_id', 'ressource_id'])
        ->mapWithKeys(fn($e) => [($e->inscription_id.'-'.$e->ressource_id) => true])
        ->all();

    $missingMcc = 0;

    DB::transaction(function () use (
        $inscriptionIds, $ressourceIds,
        $generalSet, $partSet,
        $mccMap, $devoirIdMap,
        $existing,
        &$missingMcc
    ) {
        foreach ($inscriptionIds as $inscriptionId) {
            foreach ($ressourceIds as $ressourceId) {

                $isGeneral = isset($generalSet[$ressourceId]);
                $isPart    = isset($partSet[$ressourceId]);
                if (!$isGeneral && !$isPart) continue;

                $noteSaisie = $this->compositionsApc[$inscriptionId][$ressourceId] ?? null;

                // ✅ Particulière : si vide => on n'enregistre pas (donc tu peux laisser vide)
                if ($isPart && ($noteSaisie === '' || $noteSaisie === null)) {
                    continue;
                }

                $mcc = $mccMap[$inscriptionId][$ressourceId] ?? null;
                $devoirapcId = $devoirIdMap[$inscriptionId][$ressourceId] ?? null;
                if (!$devoirapcId) $missingMcc++;

                // ✅ composition :
                // - Particulière : note saisie (obligatoire pour enregistrer)
                // - Générale : si note vide => MCC, MAIS seulement si aucune ligne n'existe déjà
                if ($isPart) {
                    $composition = (float)$noteSaisie;
                } else {
                    if ($noteSaisie === '' || $noteSaisie === null) {
                        // si existe déjà, on n'écrase pas
                        $key = $inscriptionId.'-'.$ressourceId;
                        if (isset($existing[$key])) continue;

                        // sinon on met MCC (si dispo)
                        if ($mcc === null) continue;
                        $composition = (float)$mcc;
                    } else {
                        $composition = (float)$noteSaisie;
                    }
                }

                Evalute::updateOrCreate(
                    [
                        'inscription_id' => (int)$inscriptionId,
                        'ressource_id'   => (int)$ressourceId,
                        'semestre'       => (int)$this->apcSemestre,
                      
                    ],
                    [
                        'devoirapc_id' => $devoirapcId,
                        'composition'  => $composition,
                    ]
                );
            }
        }
    });

    if ($missingMcc > 0) {
        session()->flash('error', "Enregistré: $missingMcc ligne(s) sans devoirapc_id (aucun DevoirAPC trouvé).");
    } else {
        session()->flash('success', 'Évaluations APC enregistrées avec succès.');
    }

    $this->showApcClasseModal = false;

    if (method_exists($this, 'loadApcMccAndCompositions')) {
        $this->loadApcMccAndCompositions();
    }
}

    public function render()
    {
        $absences = collect();

        if (!empty($this->selectedApprenant)) {
            $inscription = \App\Models\Inscription::find($this->selectedApprenant);

            if ($inscription) {
                $absences = \App\Models\Absence::where('inscription_id', $inscription->id)
                 
                    ->get();
            }
        }

        return view('livewire.param.classe-switch', [
            'currentClasse'        => $this->currentClasse,
            'currentApprenant'     => $this->currentApprenant,
            'classes'              => $this->classes,
            'classe'               => $this->classe,
            'apprenants'           => $this->apprenants,
            'competences'          => $this->competences,
            'evaluations'          => $this->evaluations,
            'filtres'              => $this->filtres,
            'filtre'               => $this->filtre,
            'anneeAcademiques'     => $this->anneeAcademiques,
            'annee_academique_id'  => $this->annee_academique_id,
            'anneeAcademiqueLabel' => $this->anneeAcademiqueLabel,
            'nombreApprenants'     => $this->nombreApprenants,
            'selectedsemestre1'    => $this->selectedsemestre1,
            'absences'             => $absences,
            'showApcClasseModal'   => $this->showApcClasseModal,
        ]);
    }
}
