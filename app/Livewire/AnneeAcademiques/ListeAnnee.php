<?php

namespace App\Livewire\AnneeAcademiques;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AnneeAcademique;

class ListeAnnee extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
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

    public function setSearch()
    {

    }

    public function render()
    {
        $qry = AnneeAcademique::where("dateDebut", "like", "%{$this->search}%")
                        ->orWhere('dateFin', 'like', "%{$this->search}%");
                      
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $anneeacademiques = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.anneeacademique.liste-anneeacademique', [
            "anneeacademiques"=>$anneeacademiques,
            "count"=>$count
        ]);
    }
}
