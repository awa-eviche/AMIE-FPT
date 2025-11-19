<?php

namespace App\Livewire\Parametrage\NiveauEtude;

use App\Models\Metier;
use App\Models\Diplome;
use Livewire\Component;
use App\Models\NiveauEtude;
use Livewire\WithPagination;

class ListeNiveauEtude  extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedNiveauMetier;
    public $selectedNiveau;
    public $selectedNiveauDiplome;

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

        $qry = NiveauEtude::query(); // Initialisez la variable $qry avec la requête de base

        if ($this->selectedNiveau) {
            $qry->where('id', $this->selectedNiveau);

        }
        if ($this->selectedNiveauMetier) {
            $qry->where('metier_id', $this->selectedNiveauMetier);
        }
        if ($this->selectedNiveauDiplome) {
            $qry->where('diplome_id', $this->selectedNiveauDiplome);
        }
       
        $qry->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                ->orWhere("code", 'like', "%{$this->search}%");
        });
    
        $count = $qry->count();
    
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
    
        $niveauetudes= $qry->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();
            $metiers =Metier::all();
            $diplome=Diplome::all();
        return view('livewire.parametrage.niveauetude.liste-niveauetude', [
            "diplome" => $diplome,
            "metiers" => $metiers,
            "niveauetudes" => $niveauetudes,   
            "count" => $count
        ]);
    }
}
