<?php

namespace App\Livewire\Parametrage\Metier;

use App\Models\Metier;
use App\Models\Filiere;
use Livewire\Component;
use Livewire\WithPagination;

class ListeMetier extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedMetierFiliere;
    public $selectedMetier;

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

        $qry = Metier::query(); // Initialisez la variable $qry avec la requête de base

        if ($this->selectedMetier) {
            $qry->where('id', $this->selectedMetier);
        }
    
        if ($this->selectedMetierFiliere) {
            $qry->where('filiere_id', $this->selectedMetierFiliere);
        }
       
        $qry->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%");
        });
    
        $count = $qry->count();
    
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
    
        $metiers = $qry->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();
            $filiere = Filiere::all();
            
        return view('livewire.parametrage.metier.liste-metier', [
            "filiere" => $filiere,        
            "metiers" => $metiers,   
            "count" => $count
        ]);
    }
}