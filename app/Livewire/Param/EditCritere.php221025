<?php

namespace App\Livewire\Param;


use App\Models\Competence;
use App\Models\ElementCompetence;
use Livewire\Component;
use Livewire\WithPagination;

class EditCritere extends Component
{
    use WithPagination;

    public $search = "";
    public $updateMetier = "";
    public $startLimit;
    public $count;
    public $competence = '';
    public $element = '';
    public $elements = [];

    public function updatedCompetence($value)
    {
        
        if ($value) {
            $this->elements = ElementCompetence::where('competence_id', $value)->get();
        } else {
            $this->elements = [];
        }
       
    }
   
public function render()
{
    // Récupérer tous les métiers
    $competences = Competence::all();

    // Récupérer les elements associés au métier sélectionné
    $elements = [];
    if ($this->competence) {
        $elements = ElementCompetence::where('competence_id', $this->competence)->get();
    }

    return view('livewire.param.edit-critere', [
        "competences" => $competences,
        "elements" => $elements,
    ]);
}
}