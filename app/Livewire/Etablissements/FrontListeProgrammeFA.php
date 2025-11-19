<?php

namespace App\Livewire\Etablissements;

use App\Models\Filiere;
use App\Models\Metier;
use App\Models\Secteur;
use Livewire\Component;
use Livewire\WithPagination;

class FrontListeProgramme extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit = 0;
    public $count = 0;

    public $selectedMetier;
    public $selectedFiliere;
    public $selectedSecteur;

    public function mount()
    {
        $this->startLimit = 0;
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function next()
    {
        $this->startLimit += 12;
    }

    public function prev()
    {
        $this->startLimit = max(0, $this->startLimit - 12);
    }

    public function render()
    {
        $query = Metier::query();

        // Recherche par nom
        if ($this->search) {
            $query->where("nom", "like", "%{$this->search}%");
        }

        // Filtres
        if ($this->selectedFiliere) {
            $query->where("filiere_id", $this->selectedFiliere);
        }

        if ($this->selectedSecteur) {
            $query->whereHas("filiere", function ($q) {
                $q->where("secteur_id", $this->selectedSecteur);
            });
        }

        $this->count = $query->count();
        if ($this->count == 0) $this->startLimit = 0;

        // Récupération des données filtrées
        $metiers = $query->orderBy('id', 'desc')
                         ->offset($this->startLimit)
                         ->limit(12)
                         ->get();

        // Listes pour les filtres
        $filieres = Filiere::all();
        $secteurs = Secteur::all();

        return view('livewire.etablissements.front-liste-programme', [
            'metiers' => $metiers,
            'count' => $this->count,
            'filieres' => $filieres,
            'secteurs' => $secteurs,
        ]);
    }
}
