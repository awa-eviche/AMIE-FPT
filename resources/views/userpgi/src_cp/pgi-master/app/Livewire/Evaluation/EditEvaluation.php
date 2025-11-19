<?php

namespace App\Livewire\Evaluation;


use App\Models\Metier;
use App\Models\Matiere;
use Livewire\Component;
use Livewire\WithPagination;

class EditEvaluation extends Component
{
    use WithPagination;

    public $search = "";
  
    public $startLimit;
    public $count;
    public $metier = '';
    public $matiere = '';
    public $matieres = [];

    public function updateMetier($value)
{
    // Utilisez $value pour accéder à la valeur sélectionnée
    if ($value) {
        $this->matieres = Matiere::where('metier_id', $value)->get();
    } else {
        $this->matieres = [];
    }
    // Vous pouvez utiliser $value directement pour accéder à la valeur sélectionnée
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

    return view('livewire.evaluation.edit-evaluation', [
        "metiers" => $metiers,
        "matieres" => $matieres,
    ]);
}
}