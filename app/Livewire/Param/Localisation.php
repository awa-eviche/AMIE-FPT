<?php

namespace App\Livewire\Param;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Region;
use Livewire\Component;

class Localisation extends Component
{
    public $regions;
    public $region;
    public $message;
    public $communes;
    public $commune;
    public $departements;
    public $departement;

    function mount()
{
    $this->regions = Region::all();

    if ($this->commune) {
        $commune = Commune::find($this->commune);
        if ($commune) {
            $this->departement = $commune->departement_id;
            $query = Departement::find($this->departement);
            if ($query) {
                $this->region = $query->region_id;
                $this->departements = Departement::where('region_id', $this->region)->get();
                $this->communes = Commune::where('departement_id', $this->departement)->get();
            }
        }
    }
}


    function loadDepartements()
    {
        $this->departements = [];
        $this->departement = null;
        $this->departements = Departement::where('region_id',$this->region)->get();
        $this->communes = [];
        $this->commune = null;
    }
    function loadCommunes()
    {
        $this->communes = Commune::where('departement_id',$this->departement)->get();
    }

    public function render()
    {
        return view('livewire.param.localisation',[
            'regions'=>$this->regions,
            'region'=>$this->region,
            'departements'=>$this->departements,
            'departement'=>$this->departement,
            'communes'=>$this->communes,
            'commune'=>$this->commune,
            'message'=>$this->message
        ]);
    }
}
