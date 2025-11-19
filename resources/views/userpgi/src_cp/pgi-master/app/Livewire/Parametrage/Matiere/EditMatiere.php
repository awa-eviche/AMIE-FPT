<?php

namespace App\Livewire\Parametrage\Matiere;


use App\Models\Metier;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class EditMatiere extends Component
{
    use WithPagination;

    public $search = "";
  
    public $startLimit;
    public $count;
    public $metier = '';
    public $niveau = '';
    public $niveaux = [];

    public function academiaNew($value)
{
    // Utilisez $value pour accéder à la valeur sélectionnée
    if ($value) {
        $this->niveaux = NiveauEtude::where('metier_id', $value)->get();
    } else {
        $this->niveaux = [];
    }
    // Vous pouvez utiliser $value directement pour accéder à la valeur sélectionnée
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

    return view('livewire.parametrage.matiere.edit-matiere', [
        "metiers" => $metiers,
        "niveaux" => $niveaux,
    ]);
}
}