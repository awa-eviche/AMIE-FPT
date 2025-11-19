<?php

namespace App\Livewire\Ia;

use App\Models\Commune;
use App\Models\Ia;
use App\Models\Region;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ListeIa extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedCommune;
    public $selectedIaEtablissement;
    

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
        $qry = Ia::where('isDeleted', false)
                            ->where(function($query) {
                                $query->where("nom", "like", "%{$this->search}%")
                                    ->orWhere('email', 'like', "%{$this->search}%")
                                    ->orWhere('telephone', 'like', "%{$this->search}%")
                                    ->orWhere('adresse', 'like', "%{$this->search}%");

                            });
                        // ->orderBy($this->orderField, $this->orderDirection);
        
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $ias = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        
        return view('livewire.ia.liste-ia', [
            "ias"=>$ias,
            "count"=>$count
        ]);
    }
}