<?php

namespace App\Livewire\Parametrage\ElementCompetence;

use App\Models\Metier;
use App\Models\Competence;
use App\Models\NiveauEtude;
use App\Models\ElementCompetence;
use Livewire\Component;
use Livewire\WithPagination;

class ListeElementCompetence extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit = 0;
    public $count = 0;

    public $selectedElementCompetenceMetier;
    public $selectedElementCompetenceNiveau;
    public $selectedElementCompetenceMatiere;

    public $niveaux = [];

    public function updatedSelectedElementCompetenceMetier($metierId)
    {
        $this->selectedElementCompetenceNiveau = '';
        $this->selectedElementCompetenceMatiere = '';
        $this->niveaux = NiveauEtude::where('metier_id', $metierId)->get();
    }

    public function updatedSelectedElementCompetenceNiveau($niveauId)
    {
        $this->selectedElementCompetenceMatiere = '';
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function next()
    {
        $this->startLimit += 10;
    }

    public function prev()
    {
        $this->startLimit = max(0, $this->startLimit - 10);
    }

    public function render()
    {
        $query = ElementCompetence::query();

        if ($this->selectedElementCompetenceMetier) {
            $query->whereHas('metier', function ($q) {
                $q->where('id', $this->selectedElementCompetenceMetier);
            });
        }

        if ($this->selectedElementCompetenceNiveau) {
            $query->whereHas('competence', function ($q) {
                $q->where('niveau_etude_id', $this->selectedElementCompetenceNiveau);
            });
        }

        if ($this->selectedElementCompetenceMatiere) {
            $query->where('competence_id', $this->selectedElementCompetenceMatiere);
        }

        $query->where(function ($q) {
            $q->where("nom", "like", "%{$this->search}%")
              ->orWhere('code', "like", "%{$this->search}%");
        });

        $this->count = $query->count();
        $elementcompetences = $query->orderBy('id', 'desc')
                                    ->offset($this->startLimit)
                                    ->limit(10)
                                    ->get();

        $metiers = Metier::all();

        $competences = collect();
        if ($this->selectedElementCompetenceMetier && $this->selectedElementCompetenceNiveau) {
            $competences = Competence::where('metier_id', $this->selectedElementCompetenceMetier)
                ->where('niveau_etude_id', $this->selectedElementCompetenceNiveau)
                ->get();
        }

        return view('livewire.parametrage.elementcompetence.liste-elementcompetence', [
            'elementcompetences' => $elementcompetences,
            'metiers' => $metiers,
            'niveaux' => $this->niveaux,
            'competences' => $competences,
            'count' => $this->count,
        ]);
    }
}
