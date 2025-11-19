<?php

namespace App\Livewire\Parametrage\Matiere;


use App\Models\Metier;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class CreateMatiere extends Component
{
    use WithPagination;

    public $search = "";
    public $updateMetier = "";
    public $startLimit;
    public $count;
    public $metier = '';
    public $niveau = '';
    public $niveaux = [];

    public function updatedMetier($value)
    {
        
        if ($value) {
            $this->niveaux = NiveauEtude::where('metier_id', $value)->get();
        } else {
            $this->niveaux = [];
        }
       
    }
   
public function render()
{
    // Récupérer tous les métiers
    $metiers = Metier::all();

    // Récupérer les niveaux associés au métier sélectionné
    $niveaux = [];
    if ($this->metier) {
        $niveaux = NiveauEtude::where('metier_id', $this->metier)->get();
    }

    return view('livewire.parametrage.matiere.create-matiere', [
        "metiers" => $metiers,
        "niveaux" => $niveaux,
    ]);
}
}