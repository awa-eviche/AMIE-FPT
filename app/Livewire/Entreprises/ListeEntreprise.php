<?php

namespace App\Livewire\Entreprises;

use App\Models\Entreprise;
use Livewire\Component;
use Livewire\WithPagination;

class ListeEntreprise extends Component
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

    // public function setOrderField(string $field){
    //     if($field == $this->orderField){
    //         $this->orderDirection = $this->orderDirection == "ASC" ? "DESC" : "ASC";
    //     }else {
    //         $this->orderDirection = $field;
    //         $this->orderDirection = "ASC";
    //         $this->reset("orderDirection");
    //     }
    // }

    // public function updating($name, $value){
    //     if($name == "search"){
    //         $this->resetPage();
    //     }
    // }

    public function render()
    {

        $qry = Entreprise::where("nom_entreprise", "like", "%{$this->search}%")
                        ->orWhere('email_entreprise', 'like', "%{$this->search}%")
                        ->orWhere('ninea', 'like', "%{$this->search}%");
                        // ->orderBy($this->orderField, $this->orderDirection);
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $entreprises = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.entreprises.liste-entreprise', [
            "entreprises"=>$entreprises,
            "count"=>$count
        ]);
    }
}
