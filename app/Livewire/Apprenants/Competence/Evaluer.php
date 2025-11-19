<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Critere;
use App\Models\ElementCompetence;
use Livewire\Component;

class Evaluer extends Component
{
    public $competences;
    public $competence;
    public $message;
    public $criteres;
    public $critere;
    public $ecompetences;
    public $ecompetence;

    function mount()
    {
        if($this->critere)
        {
            $critere = Critere::find($this->critere);
            $this->ecompetence = $critere->element_competence_id;
            $query = ElementCompetence::find($this->ecompetence);
            $this->competence = $query->competence_id;
            $this->ecompetences = ElementCompetence::where('region_id',$this->region)->get();
            $this->criteres = Critere::where('element_competence_id',$this->ecompetence)->get();
        }
    }

    function loadEcompetences()
    {
        $this->ecompetences = [];
        $this->ecompetence = null;
        $this->ecompetences = ElementCompetence::where('competence_id',$this->competence)->get();
        $this->criteres = [];
        $this->critere = null;
    }
    function loadCriteres()
    {
        $this->criteres = Critere::where('element_competence_id',$this->ecompetence)->get();
    }

    public function render()
    {
        return view('livewire.apprenants.competence.evaluer',[
            'competences'=>$this->competences,
            'competence'=>$this->competence,
            'ecompetences'=>$this->ecompetences,
            'ecompetence'=>$this->ecompetence,
            'criteres'=>$this->criteres,
            'critere'=>$this->critere,
            'message'=>$this->message
        ]);
    }
}
