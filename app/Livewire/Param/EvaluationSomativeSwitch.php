<?php

namespace App\Livewire\Param;

use App\Models\Classe;
use App\Models\Competence;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use App\Models\Sommation;
use App\Models\Ressource;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EvaluationSomativeSwitch extends Component
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
public $nombreApprenants = 0;   
public bool $showSomativeClasseModal = false;
public $somativeSemestre = "";
public array $apprenantsSomativeModal = [];
public $rowspans = [];
public array $somativeExisting = []; 
public array $somativeStatut = []; 
public array $somativeDate   = [];
public array $somativeObs    = [];
public $competencesGenerales;
public $competencesParticulieres;


public array $somativeNoteRessource = [];
public array $somativeDateRessource = [];
public array $somativeObsRessource  = [];



public function openSomativeClasseModal()
{
    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', "Veuillez sélectionner une classe et une année académique.");
        return;
    }

    $classe = Classe::find($this->classe);
    if (!$classe) {
        session()->flash('error', "Classe introuvable.");
        return;
    }

    $this->showSomativeClasseModal = true;

    $this->apprenantsSomativeModal = Inscription::with('apprenant')
        ->where('classe_id', $this->classe)
        ->where('annee_academique_id', $this->annee_academique_id)
        ->orderBy('id', 'asc')
        ->get()
        ->all();

    $niveauId = (int) $classe->niveau_etude_id;
    $classeId = (int) $classe->id;

    
 $this->competencesGenerales = Competence::query()
    ->where('niveau_etude_id', $niveauId)
    ->where('type', 'generale')

    
    ->whereHas('ressources', function ($q) use ($classeId) {
        $q->whereHas('classe', function ($qq) use ($classeId) {
            $qq->where('classes.id', $classeId);
        });
    })


    ->with(['ressources' => function ($q) use ($classeId) {
        $q->whereHas('classe', function ($qq) use ($classeId) {
            $qq->where('classes.id', $classeId);
        })
        ->orderBy('nom');
    }])

    ->orderBy('nom')
    ->get();



    $this->competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->with(['elementCompetences.criteres'])
        ->orderBy('nom')
        ->get();

    
    $this->rowspans = [];
    foreach ($this->competencesParticulieres as $idx => $comp) {
        $sum = 0;
        foreach (($comp->elementCompetences ?? collect()) as $el) {
            $sum += (($el->criteres ?? collect())->count());
        }
        $this->rowspans[$idx] = max($sum, 1);
    }

    $this->somativeExisting = [];
    $this->somativeStatut   = [];
    $this->somativeDate     = [];
    $this->somativeObs      = [];

    if (!empty($this->somativeSemestre)) {
        $this->loadSomativeExisting();
    }
}





public function closeSomativeClasseModal()
{
    $this->showSomativeClasseModal = false;
}


public function updatedSomativeSemestre()
{
    if($this->showSomativeClasseModal){
        $this->loadSomativeExisting();
          $this->openSomativeClasseModal(); 
    }
}
public function saveSomativeClasse()
{
    if (empty($this->somativeSemestre)) {
        session()->flash('error', "Veuillez sélectionner un semestre.");
        return;
    }

    DB::transaction(function () {

        /* ==============================
           1️⃣ COMPÉTENCES GÉNÉRALES
           ==============================*/
        if (!empty($this->somativeNoteRessource)) {

            foreach ($this->somativeNoteRessource as $inscId => $ressources) {

                foreach ($ressources as $ressourceId => $note) {

                    if ($note === "" || $note === null) continue;

                    Sommation::updateOrCreate(
                        [
                            'inscription_id' => $inscId,
                            'ressource_id'   => $ressourceId,
                            'critere_id'     => null,
                            'semestre'       => $this->somativeSemestre,
                        ],
                        [
                            'note'      => (float) $note,
                            'acquis'    => null,
                            'nonacquis' => null,
                        ]
                    );
                }
            }
        }

        /* ==============================
           2️⃣ COMPÉTENCES PARTICULIÈRES
           ==============================*/
        if (!empty($this->somativeStatut)) {

            foreach ($this->somativeStatut as $inscId => $criteres) {

                foreach ($criteres as $critereId => $valeur) {

                    if ($valeur === "" || $valeur === null) continue;

                    Sommation::updateOrCreate(
                        [
                            'inscription_id' => $inscId,
                            'critere_id'     => $critereId,
                            'ressource_id'   => null,
                            'semestre'       => $this->somativeSemestre,
                        ],
                        [
                            'note'      => null,
                            'acquis'    => $valeur == 2 ? 1 : 0,
                            'nonacquis' => $valeur == 0 ? 1 : 0,
                        ]
                    );
                }
            }
        }

    });

    session()->flash('success', "Évaluation sommative enregistrée avec succès.");
}

private function loadSomativeExisting()
{
    if(empty($this->somativeSemestre)) return;

    $inscIds = collect($this->apprenantsSomativeModal)->pluck('id')->toArray();

    $rows = \App\Models\Sommation::query()
        ->whereIn('inscription_id', $inscIds)
        ->where('semestre', $this->somativeSemestre)
        ->get();

    foreach($rows as $r){

      
        if(!empty($r->ressource_id) && empty($r->critere_id)){
            $this->somativeNoteRessource[$r->inscription_id][$r->ressource_id] = $r->note;
            $this->somativeDateRessource[$r->inscription_id][$r->ressource_id] = $r->date ? \Carbon\Carbon::parse($r->date)->format('Y-m-d') : null;
            $this->somativeObsRessource[$r->inscription_id][$r->ressource_id]  = $r->observations ?? '';
            continue;
        }
    $this->somativeStatut = [];

    $records = \App\Models\Sommation::where('semestre', $this->somativeSemestre)
        ->whereIn('inscription_id', collect($this->apprenantsSomativeModal)->pluck('id'))
        ->get();

    foreach ($records as $record) {

        if ($record->acquis == 1) {
            $this->somativeStatut[$record->inscription_id][$record->critere_id] = 2;
        }

        if ($record->nonacquis == 1) {
            $this->somativeStatut[$record->inscription_id][$record->critere_id] = 0;
        }
    }
      
    }
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

       
        if (session()->has('evaluation_classe_id')) {
            $this->classe = session('evaluation_classe_id');
            $this->updatedClasse();
        }
        if (session()->has('evaluation_annee_academique_id')) {
            $this->annee_academique_id = session('evaluation_annee_academique_id');
            $this->updatedAnneeAcademiqueId();
        }
    }

    public function updatedClasse()
    {
        session()->put('currentClasse', $this->classe);

        $this->currentClasse = Classe::with(['etablissement','niveau_etude.metier.filiere'])
            ->find($this->classe);

        $this->loadApprenants();
        $this->resetSelection();
    }

    public function updatedAnneeAcademiqueId()
    {
        session()->put('annee_academique_id', $this->annee_academique_id);

        $this->anneeAcademiqueLabel = optional(
            $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)
        )->code;

        $this->loadApprenants();
        $this->resetSelection();
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

        $user = auth()->user();
        $classe = $this->currentApprenant->classe;

        $competenceIds = [];

        if ($user->hasRole('formateur')) {
            $competenceIds = DB::table('classe_formateur_competence')
                ->where('classe_id', $classe->id)
                ->where('formateur_id', $user->id)
                ->pluck('competence_id')
                ->toArray();
        }

        if (empty($competenceIds) && $user->hasRole('formateur')) {
            $this->competences = collect();
            return;
        }

        $query = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
            ->with('elementCompetences.criteres');

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

        $user = auth()->user();
        $classe = optional($this->currentApprenant)->classe;
        $semestre = $this->selectedsemestre1;

        $query = Sommation::where('inscription_id', $this->selectedApprenant)
            ->where('semestre', $semestre);

        // mêmes restrictions formateur (limiter aux critères de ses compétences)
        if ($user->hasRole('formateur') && $classe) {
            $competenceIds = DB::table('classe_formateur_competence')
                ->where('classe_id', $classe->id)
                ->where('formateur_id', $user->id)
                ->pluck('competence_id')
                ->toArray();

            if (!empty($competenceIds)) {
                $critereIds = DB::table('criteres')
                    ->join('element_competences', 'criteres.element_competence_id', '=', 'element_competences.id')
                    ->whereIn('element_competences.competence_id', $competenceIds)
                    ->pluck('criteres.id')
                    ->toArray();

                $query->whereIn('critere_id', $critereIds);
            } else {
                $query->whereRaw('1=0');
            }
        }

        $this->evaluations = $query->get()->keyBy('critere_id')->toArray();
    }

    public function render()
    {
        return view('livewire.param.evaluation-somative-switch', [
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
        ]);
    }
}
