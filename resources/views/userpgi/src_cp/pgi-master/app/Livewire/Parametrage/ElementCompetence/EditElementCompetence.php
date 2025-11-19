<?php

namespace App\Livewire\Parametrage\ElementCompetence;


use App\Models\Metier;
use App\Models\Matiere;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class EditElementCompetence extends Component
{
    use WithPagination;

    public $search = "";
  
    public $startLimit;
    public $count;
    public $metier = '';
    public $niveau = '';
    public $matieres = [];

    public function academiaNew($value)
{
    
    if ($value) {
        $this->matieres = Matiere::where('metier_id', $value)->get();
    } else {
        $this->matieres = [];
    }
  
}
public function render()
{
    // Récupérer tous les métiers
    $metiers = Metier::all();

    // Récupérer les niveaux associés au métier sélectionné
    $matieres = [];
    if ($this->metier) {
        $matieres = Matiere::where('metier_id', $this->metier)->get();
    }

    return view('livewire.parametrage.elementcompetence.edit-elementcompetence', [
        "metiers" => $metiers,
        "matieres" => $matieres,
    ]);
}
}