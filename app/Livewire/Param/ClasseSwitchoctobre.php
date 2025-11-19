<?php

namespace App\Livewire\Param;

use App\Models\Classe;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\Etablissement;
use App\Models\Apprenant;
use App\Models\AnneeAcademique;
use Livewire\Component;

class ClasseSwitch extends Component
{
    public $classe;
    public $currentClasse;
    public $currentApprenant;
    public $classes;
    public $apprenants = [];
    public $selectedApprenant;
    public $annee_academique_id;
    public $anneeAcademiques;
    public $anneeAcademiqueLabel;
    public $search = "";
    public $startLimit;
    public $count;
    public $evaluations = [];
    public $competences = [];
    public $criteres = [];
    public $filtre;
    public $filtres;
    public $nombreApprenants = 0;
public $selectedsemestre;

public function updatedSelectedsemestre($value)
{
    session()->put('selectedsemestre', $value);
}

    public function mount()
    {
        $this->fill([
            'search'        => '',
            'startLimit'    => 0,
            'count'         => 0,
        ]);

        $this->anneeAcademiques = AnneeAcademique::all();
        $this->annee_academique_id = session()->get('annee_academique_id', '');

        // Récupère uniquement les classes ayant la modalité "APC"
        if (auth()->user()->hasRole('superadmin')) {
            $this->classes = Classe::where('modalite', 'APC')->get();
        } else {
            $etabId = auth()->user()->etablissementId()
                ?? Etablissement::where('email', auth()->user()->email)->value('id');

            $this->classes = $etabId
                ? Classe::where('modalite', 'APC')->where('etablissement_id', $etabId)->get()
                : collect();
        }

        $this->classe = session()->get('currentClasse', '');
      //  $this->currentClasse = $this->classe ? Classe::find($this->classe) : null;
$this->currentClasse = $this->classe ? Classe::with('formateurs')->find($this->classe) : null;
        $this->apprenants = $this->loadApprenants();

        $this->selectedApprenant = session()->get('currentApprenant', null);
        $this->currentApprenant = null;

        $this->anneeAcademiqueLabel = $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)?->code;
    }

    public function updatedClasse()
    {
        session()->put('currentClasse', $this->classe);
        session()->forget('currentApprenant');
        //$this->currentClasse = Classe::find($this->classe);
 $this->currentClasse = Classe::with('formateurs')->find($this->classe);
        $this->apprenants = $this->loadApprenants();
    }

    public function updatedAnneeAcademiqueId()
    {
        session()->put('annee_academique_id', $this->annee_academique_id);
        $this->anneeAcademiqueLabel = $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)?->code;
        $this->apprenants = $this->loadApprenants();
    }

    public function loadApprenants()
    {
        if (!$this->classe || !$this->annee_academique_id) {
            $this->nombreApprenants = 0;
            return collect();
        }
    
        $apprenants = Inscription::with(['apprenant.user', 'anneeAcademique'])
            ->where('classe_id', $this->classe)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->whereHas('classe', fn($query) => $query->where('modalite', 'APC'))
            ->get();
    
        $this->nombreApprenants = $apprenants->count();
    
        return $apprenants;
    }
    

    public function loadCompetences($id)
    {
        $this->selectedApprenant = $id;
        session()->put('currentApprenant', $id);
        return redirect()->route('competence.manage.index');
    }

    public function next()
    {
        $this->startLimit += 2;
    }

    public function prev()
    {
        $this->startLimit -= 2;
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function render()
    {
        $inscription = null;
        $rowspans = [];

        if ($this->selectedApprenant) {
            $inscription = Inscription::find($this->selectedApprenant);
            $this->currentApprenant = $inscription;

            $this->evaluations = Evalute::where('inscription_id', $this->selectedApprenant)
                ->get()
                ->keyBy('id')
                ->toArray();

            $competencesQuery = Competence::where('niveau_etude_id', optional($inscription->classe)->niveau_etude_id);

 if ($this->classe && !$this->currentClasse) {
                $this->currentClasse = Classe::with('formateurs')->find($this->classe);
            }

            if ($this->filtre) {
                $competencesQuery->where('id', $this->filtre);
            }

            $this->count = $competencesQuery->count();
            if ($this->count == 0 || $this->filtre) {
                $this->startLimit = 0;
            }

            $this->competences = $competencesQuery
                ->with('elementCompetences.criteres')
                ->orderBy('id', 'asc')
                ->offset($this->startLimit)
                ->limit(2)
                ->get();

            foreach ($this->competences as $key => $competence) {
                $rowspan = 0;
                foreach ($competence->elementCompetences ?? [] as $ec) {
                    $rowspan += sizeof($ec->criteres);
                    $this->criteres = array_merge($this->criteres, $ec->criteres->toArray());
                }
                $rowspans[$key] = $rowspan;
            }

            $this->filtres = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)->get();
        }

        return view('livewire.param.classe-switch', [
            'rowspans' => $rowspans,
            'startLimit' => $this->startLimit,
            'count' => $this->count,
            'criteres' => $this->criteres,
            'evaluations' => $this->evaluations,
            'competences' => $this->competences,
            'classes' => $this->classes,
            'classe' => $this->classe,
            'currentClasse' => $this->currentClasse,
            'apprenants' => $this->apprenants,
            'selectedApprenant' => $this->selectedApprenant,
            'currentApprenant' => $this->currentApprenant,
            'inscription' => $inscription ?? '',
            'filtre' => $this->filtre,
            'filtres' => $this->filtres,
            'annee_academique_id' => $this->annee_academique_id,
            'anneeAcademiques' => $this->anneeAcademiques,
            'anneeAcademiqueLabel' => $this->anneeAcademiqueLabel,
        ]);
    }
}
