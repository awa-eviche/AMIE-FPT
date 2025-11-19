<?php

namespace App\Livewire\Parametrage\TypeIndicateur;

use App\Models\TypeIndicateur;
use Livewire\Component;
use Livewire\WithPagination;

class ListeTypeIndicateur extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;

    // public $orderField = "";
    // public $orderDirection = "ASC";

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

    public function setSearch(){

    }

    public function render()
    {

        $qry = TypeIndicateur::where("libelle", "like", "%{$this->search}%")
                        ->orWhere('code', 'like', "%{$this->search}%");
                        
                        // ->orderBy($this->orderField, $this->orderDirection);
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $typeindicateur = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.parametrage.typeindicateur.liste-type-indicateur', [
            "typeindicateur"=>$typeindicateur,
            "count"=>$count
        ]);
    }
}
