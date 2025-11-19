<?php

namespace App\Livewire\Param;

use App\Models\ElementCompetence;
use Livewire\Component;

class Critere extends Component
{
    public $search = "";
    public $startLimit;
    public $count;

    public $selectedElement;
    public $elements;

    // public $orderField = "";
    // public $orderDirection = "ASC";

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
            'elements' => ElementCompetence::all(),
            'selectedElement' => ''
        ]);
    }

    function next()
    {
        $this->startLimit += 10 ;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch(){

    }

    public function render()
    {
        if($this->selectedElement)
        {
            $qry = \App\Models\Critere::join('element_competences', 'criteres.element_competence_id', '=', 'element_competences.id')
                                        ->where("element_competences.id", $this->selectedElement)
                                        ->where(function($query) {
                                            $query->orWhere("criteres.libelle", "like", "%{$this->search}%")
                                           //     ->orWhere('criteres.code', 'like', "%{$this->search}%")
                                                ->orWhere('element_competences.nom', 'like', "%{$this->search}%");
                                        });
        }
        else
        {
            $qry = \App\Models\Critere::join('element_competences','criteres.element_competence_id','=','element_competences.id')
                            ->where("criteres.libelle", "like", "%{$this->search}%")
                           // ->orWhere('criteres.code', 'like', "%{$this->search}%")
                            ->orWhere('element_competences.nom', 'like', "%{$this->search}%");
        }

        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $criteres = $qry->select('criteres.*')->orderBy('criteres.id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.param.critere', [
            "criteres"=>$criteres,
            "count"=>$count,
            "elements"=>$this->elements,
            "selectedElement"=>$this->selectedElement
        ]);
    }
}
