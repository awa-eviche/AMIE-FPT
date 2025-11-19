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
    public $apprenants;
    public $selectedApprenant;
    public $annee_academique_id;
    public $search = "";
    public $startLimit;
    public $count;
    public $evaluations;
    public $competences;
    public $criteres;
    public $filtre;
    public $filtres;

    public function mount()
    {
        $this->fill([
            'search'        => '',
            'startLimit'    => 0,
            'count'         => 0,
            'criteres'      => [],
            'evaluations'   => [],
            'competences'   => []
        ]);

        // Récupère uniquement les classes ayant la modalité "APC"
        if (auth()->user()->hasRole('superadmin')) {
            $this->classes = Classe::where('modalite', 'APC')->get();
        } else {
            $etabId = auth()->user()->etablissementId()
                   ?? Etablissement::where('email', auth()->user()->email)->value('id');
            $this->etablissement_id = $etabId;

            $this->classes = $etabId
                ? Classe::where('modalite', 'APC')
                        ->where('etablissement_id', $etabId)
                        ->get()
                : collect();
        }

        $this->classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $this->currentClasse = $this->classe ? Classe::find($this->classe) : null;

        $this->apprenants = $this->loadApprenants();

        $this->selectedApprenant = session()->has('currentApprenant') ? session()->get('currentApprenant') : null;
        $this->currentApprenant = null;
    }

    public function updatedClasse()
    {
        session()->put('currentClasse', $this->classe);
        session()->forget('currentApprenant');
        $this->currentClasse = Classe::find($this->classe);
        $this->apprenants = $this->loadApprenants();
    }

    public function updatedAnneeAcademiqueId()
    {
        $this->apprenants = $this->loadApprenants();
    }

    public function loadApprenants()
    {
        if (!$this->classe) return collect();

        return Inscription::with('apprenant.user')
            ->where('classe_id', $this->classe)
            ->when($this->annee_academique_id, function ($query) {
                $query->where('annee_academique_id', $this->annee_academique_id);
            })
            ->whereHas('classe', function ($query) {
                $query->where('modalite', 'APC');
            })
            ->get();
    }

    public function loadCompetences($id)
    {
        $this->selectedApprenant = $id;
        session()->put('currentApprenant', $id);
        session()->save();
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
        ]);
    }
}
