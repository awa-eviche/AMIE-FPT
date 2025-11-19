<?php

namespace App\Livewire\Listes;

use App\Models\Liste;
use Livewire\Component;
use Livewire\WithPagination;

class ListeListe extends Component
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

       /* $qry = liste::where('isDeleted', false)
                            ->where(function($query) {
                                $query->where("valeur", "like", "%{$this->search}%")
                                    ->orWhere('libelle', 'like', "%{$this->search}%");
                            });*/
                        // ->orderBy($this->orderField, $this->orderDirection);
        $qry = liste::where(function($query) {
                            $query->where("valeur", "like", "%{$this->search}%")
                                ->orWhere('libelle', 'like', "%{$this->search}%");
                        });
        
        $count = $qry->count();


        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $listes = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        
        return view('livewire.listes.liste-liste', [
            "listes"=>$listes,
            "count"=>$count
        ]);
    }
}
