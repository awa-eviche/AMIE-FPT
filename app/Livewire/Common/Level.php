<?php

namespace App\Livewire\Common;

use Livewire\Component;
use App\Models\Secteur;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use Illuminate\Support\Facades\Log;




class Level extends Component
{

    public $secteurs = [];
    public $filieres = [];
    public $metiers = [];
    public $niveauetudes = [];


    public $selectedSecteur;
    public $selectedFiliere;
    public $selectedMetier;
    public $selectedNiveau;


    public function mount()
    {
        $this->secteurs = Secteur::all();
    }

    public function render()
    {
        if($this->selectedSecteur)
        {
            $this->filieres = Filiere::where('secteur_id', $this->selectedSecteur)->get();
        }

        if($this->selectedSecteur && $this->selectedFiliere)
        {
            $this->metiers = Metier::where('filiere_id', $this->selectedFiliere)->get();
        }

        if($this->selectedSecteur && $this->selectedFiliere && $this->selectedMetier)
        {
            $this->niveauetudes = NiveauEtude::where('metier_id', $this->selectedMetier)->get();
        }
        return view('livewire.common.level', ["secteurs"=> $this->secteurs, "filieres"=> $this->filieres, "metiers"=> $this->metiers, "niveauetudes"=> $this->niveauetudes]);
    }
}
