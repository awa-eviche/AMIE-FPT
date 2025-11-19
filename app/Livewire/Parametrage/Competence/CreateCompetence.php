<?php

namespace App\Livewire\Parametrage\Competence;


use App\Models\Metier;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class CreateCompetence extends Component
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
    //$metiers = Metier::all();
 $metiers = Metier::orderBy('nom', 'asc')->get();
    // Récupérer les niveaux associés au métier sélectionné
    $niveaux = [];
    if ($this->metier) {
        $niveaux = NiveauEtude::where('metier_id', $this->metier)->get();
    }

    return view('livewire.parametrage.competence.create-competence', [
        "metiers" => $metiers,
        "niveaux" => $niveaux,
    ]);
}
}
