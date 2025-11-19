<?php

namespace App\Livewire\Parametrage\ElementCompetence;


use App\Models\Metier;
use App\Models\Competence;
use Livewire\Component;
use Livewire\WithPagination;

class CreateElementCompetence extends Component
{
    use WithPagination;

    public $search = "";
    public $updateMetier = "";
    public $startLimit;
    public $count;
    public $metier = '';
    public $niveau = '';
    public $competences = [];

    public function updatedMetier($value)
    {
        
        if ($value) {
            $this->competences = Competence::where('metier_id', $value)->get();
        } else {
            $this->competences = [];
        }
       
    }
   
public function render()
{
    // Récupérer tous les métiers
//    $metiers = Metier::all();
 $metiers = Metier::orderBy('nom', 'asc')->get();
    // Récupérer les niveaux associés au métier sélectionné
    $competences = [];
    if ($this->metier) {
        $competences = Competence::where('metier_id', $this->metier)->get();
    }

    return view('livewire.parametrage.elementcompetence.create-elementcompetence', [
        "metiers" => $metiers,
        "competences" => $competences,
    ]);
}
}
