<?php

namespace App\Livewire\Parametrage\Matiere;

use App\Models\Metier;
use App\Models\Matiere;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class ListeMatiere extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;
    public $selectedMatiere;
    public $selectedMatiereMetier;
    public $selectedMatiereNiveau;

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

    public function updatedSelectedMatiereMetier($value)
    {
        $this->selectedMatiereNiveau = ''; // Réinitialiser le niveau si le métier change
    }

    public function render()
    {
        $qry = Matiere::query();

        if ($this->selectedMatiere) {
            $qry->where('id', $this->selectedMatiere);
        }

        if ($this->selectedMatiereMetier) {
            $qry->where('metier_id', $this->selectedMatiereMetier);
        }

        if ($this->selectedMatiereNiveau) {
            $qry->where('niveau_etude_id', $this->selectedMatiereNiveau);
        }

        $qry->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                  ->orWhere('code', 'like', "%{$this->search}%");
        });

        $count = $qry->count();
        $this->count = $count;
        if ($count == 0) {
            $this->startLimit = 0;
        }

        $matieres = $qry->orderBy('id', 'desc')
                        ->offset($this->startLimit)
                        ->limit(10)
                        ->get();

        $metiers = Metier::all();

        // ✅ Niveaux filtrés par métier
        $niveau = $this->selectedMatiereMetier
            ? NiveauEtude::where('metier_id', $this->selectedMatiereMetier)->get()
            : collect();

        return view('livewire.parametrage.matiere.liste-matiere', [
            "matieres" => $matieres,
            "metiers" => $metiers,
            "niveau" => $niveau,
            "count" => $count,
        ]);
    }
}
