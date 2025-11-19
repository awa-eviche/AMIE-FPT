<?php

namespace App\Livewire\Parametrage\ElementCompetence;

use App\Models\Metier;
use App\Models\Matiere;
use App\Models\NiveauEtude;
use App\Models\ElementCompetence;
use Livewire\Component;
use Livewire\WithPagination;

class ListeElementCompetence extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;
    public $selectedElementCompetence;
    public $selectedElementCompetenceMetier;
    public $selectedElementCompetenceMatiere;

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
        ]);
    }

    function next()
    {
        $this->startLimit += 10;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function render()
    {
        $query = ElementCompetence::query();
    
        if ($this->selectedElementCompetenceMetier) {
            $query->whereHas('metier', function ($q) {
                $q->where('id', $this->selectedElementCompetenceMetier);
            });
        }
    
        if ($this->selectedElementCompetenceMatiere) {
            $query->where('matiere_id', $this->selectedElementCompetenceMatiere);
        }
    
        $query->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%");
        });
    
        $count = $query->count();
    
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
    
        $elementcompetences = $query->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();
    
        $metiers = Metier::all();
        $matieres = Matiere::all();
    
        return view('livewire.parametrage.elementcompetence.liste-elementcompetence', [
            "elementcompetences" => $elementcompetences,
            "metiers" => $metiers,
            "matieres" => $matieres,
            "count" => $count
        ]);
    }
    
}
