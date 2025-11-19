<?php

namespace App\Livewire\Inspecteur;

use App\Models\Inspecteur;
use Livewire\Component;
use Livewire\WithPagination;

class ListeInspecteur extends Component
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

    public function setSearch(){

    }

  

    public function render()
    {

        $qry = Inspecteur::where('isDeleted', false)
                            ->where(function($query) {
                                $query->where("specialite", "like", "%{$this->search}%");
                                    // ->orWhere('email', 'like', "%{$this->search}%");
                            });
                        // ->orderBy($this->orderField, $this->orderDirection);
        
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $inspecteurs = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        
        return view('livewire.inspecteur.liste-inspecteur', [
            "inspecteurs"=>$inspecteurs,
            "count"=>$count
        ]);
    
    }
}
