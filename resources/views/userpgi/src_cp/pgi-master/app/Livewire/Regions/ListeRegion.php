<?php

namespace App\Livewire\Regions;

use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Li;


class ListeRegion extends Component
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

        $qry = Region::where('isDeleted', false)
                            ->where(function($query) {
                                $query->where("code", "like", "%{$this->search}%")
                                    ->orWhere('libelle', 'like', "%{$this->search}%");
                            });
                        // ->orderBy($this->orderField, $this->orderDirection);
        
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $regions = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        
        return view('livewire.regions.liste-region', [
            "regions"=>$regions,
            "count"=>$count
        ]);
    }
}
