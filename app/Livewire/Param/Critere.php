<?php

namespace App\Livewire\Param;

use Livewire\Component;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Competence;
use App\Models\ElementCompetence;
use App\Models\Critere as CritereModel;

class Critere extends Component
{
    public $search = "";
    public $startLimit;
    public $count;

    // Sélections
    public $selectedMetier = '';
    public $selectedNiveau = '';
    public $selectedCompetence = '';
    public $selectedElement = '';

    // Collections
    public $metiers = [];
    public $niveaux = [];
    public $competences = [];
    public $elements = [];

    /**
     * Initialisation
     */
    public function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
           // 'metiers' => Metier::all(),
'metiers' => Metier::orderBy('nom', 'asc')->get(),

            'niveaux' => [],
            'competences' => [],
            'elements' => [],
        ]);
    }

    /**
     * Pagination manuelle
     */
    public function next()
    {
        $this->startLimit += 10;
    }

    public function prev()
    {
        $this->startLimit = max(0, $this->startLimit - 10);
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    /**
     * Mise à jour des listes déroulantes
     */
    public function updatedSelectedMetier($metierId)
    {
        $this->niveaux = NiveauEtude::where('metier_id', $metierId)->get();
        $this->selectedNiveau = '';
        $this->competences = [];
        $this->elements = [];
    }

    public function updatedSelectedNiveau($niveauId)
    {
        $this->competences = Competence::where('niveau_etude_id', $niveauId)->get();
        $this->selectedCompetence = '';
        $this->elements = [];
    }

    public function updatedSelectedCompetence($competenceId)
    {
        $this->elements = ElementCompetence::where('competence_id', $competenceId)->get();
        $this->selectedElement = '';
    }

    /**
     * Rendu de la vue
     */
    public function render()
    {
        $qry = CritereModel::query()
            ->join('element_competences', 'criteres.element_competence_id', '=', 'element_competences.id');

        if ($this->selectedMetier) {
            $qry->whereHas('elementCompetence.competence.metier', function ($q) {
                $q->where('id', $this->selectedMetier);
            });
        }

        if ($this->selectedNiveau) {
            $qry->whereHas('elementCompetence.competence', function ($q) {
                $q->where('niveau_etude_id', $this->selectedNiveau);
            });
        }

        if ($this->selectedCompetence) {
            $qry->whereHas('elementCompetence', function ($q) {
                $q->where('competence_id', $this->selectedCompetence);
            });
        }

        if ($this->selectedElement) {
            $qry->where("element_competences.id", $this->selectedElement);
        }

        if ($this->search) {
            $qry->where(function ($query) {
                $query->where("criteres.libelle", "like", "%{$this->search}%")
                      ->orWhere('element_competences.nom', 'like', "%{$this->search}%");
            });
        }

        $count = $qry->count();
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $criteres = $qry->select('criteres.*')
                        ->orderBy('criteres.id', 'desc')
                        ->offset($this->startLimit)
                        ->limit(10)
                        ->get();

        return view('livewire.param.critere', [
            "criteres" => $criteres,
            "count" => $count,
            "metiers" => $this->metiers,
            "niveaux" => $this->niveaux,
            "competences" => $this->competences,
            "elements" => $this->elements,
            "selectedMetier" => $this->selectedMetier,
            "selectedNiveau" => $this->selectedNiveau,
            "selectedCompetence" => $this->selectedCompetence,
            "selectedElement" => $this->selectedElement,
        ]);
    }
}
