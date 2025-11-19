<?php

namespace App\Livewire\Parametrage\Filiere;

use App\Models\Secteur;
use App\Models\Filiere;
use Livewire\Component;
use Livewire\WithPagination;

class ListeFiliere extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedFiliereSecteur;
    public $selectedFiliere;

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

        $qry = Filiere::query(); // Initialisez la variable $qry avec la requête de base

        if ($this->selectedFiliere) {
            $qry->where('id', $this->selectedFiliere);
        }
    
        if ($this->selectedFiliereSecteur) {
            $qry->where('secteur_id', $this->selectedFiliereSecteur);
        }
       
        $qry->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%");
        });
    
        $count = $qry->count();
    
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
    
        $filieres = $qry->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();
            $secteur = Secteur::all();
            
        return view('livewire.parametrage.filiere.liste-filiere', [
            "secteur" => $secteur,        
            "filieres" => $filieres,   
            "count" => $count
        ]);
    }
}