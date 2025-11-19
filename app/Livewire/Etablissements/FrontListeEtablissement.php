<?php

namespace App\Livewire\Etablissements;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;

class FrontListeEtablissement extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedMetier;
    public $selectedRegion;
    public $selectedDepartement;
    public $selectedCommune;
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
        $this->startLimit += 12 ;
    }

    function prev()
    {
        $this->startLimit -= 12;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch(){

    }


    public function render()
    {

        $restr = array();
        $query = Etablissement::where([]);

        if($this->search) {
            $query->where(
                function($result) {
                    $result
                    ->where("email", "like" , "%{$this->search}%")
                    ->orWhere("sigle", "like" , "%{$this->search}%")
                    ->orWhere("telephone", "like" , "%{$this->search}%")
                    ->orWhere("nom", "like" , "%{$this->search}%")
                    ->orWhere("adresse", "like" , "%{$this->search}%");
                }
                );
            }

        if ($this->selectedFiliere) {
            $restr[] = ["filiere_id", "=", $this->selectedFiliere];
            $metiers = Metier::where('filiere_id', $this->selectedFiliere)->get();
        } else {
            $metiers = [];
        }

        if ($this->selectedMetier) {
            $metier = Metier::findOrFail($this->selectedMetier);
            $restr[] = ["filiere_id", "=", $metier->filiere->id];
        }

        if ($this->selectedRegion) {
            $restr[] = ["region", "=", $this->selectedRegion];
            $departements = Departement::where('region_id', $this->selectedRegion)->get();
        } else {
            $departements = [];
        }

        if ($this->selectedDepartement) {
            $restr[] = ["departement", "=", $this->selectedDepartement];
            $communes = Commune::where('departement_id', $this->selectedDepartement)->get();
        } else {
            $communes = [];
        }

        if ($this->selectedCommune) {
            $restr[] = ["commune_id", "=", $this->selectedCommune];
        }

        if(count($restr)) {
            foreach ($restr as $r) {
                if($r[0] == "departement") {
                    $query = $query->with(['commune'])->whereHas('commune.departement', function ($query) {
                        $query->where('id', $this->selectedDepartement);
                    });
                } elseif($r[0] == "region") {
                    $query =  $query->with(['commune'])->whereHas('commune.departement.region', function ($query) {
                        $query->where('id', $this->selectedRegion);
                    });
                } else {
                    $query = $query->where($r[0], $r[1], $r[2]);
                }
            }
        }
        $count = $query->count();

        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $antennes = [];
        // $communes = Commune::all();
        $filieres = Filiere::all();
        $regions = Region::all();

        $etablissements = $query->orderBy('id','desc')->offset($this->startLimit)->limit(12)->get();
        return view('livewire.etablissements.front-liste-etablissement', [
            "etablissements"=>$etablissements,
            "count"=>$count,
            "regions"=>$regions,
            "departements"=>$departements,
            "communes"=>$communes,
        ]);
    }
}
