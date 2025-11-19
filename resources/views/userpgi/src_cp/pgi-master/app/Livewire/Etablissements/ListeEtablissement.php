<?php

namespace App\Livewire\Etablissements;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Region;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;


class ListeEtablissement extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;

    public $selectedCommune;
    public $selectedDepartement;
    public $selectedRegion;

    public $departementList = [];
    public $communeList = [];



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
        $this->startLimit += 10;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {
    }



    public function render()
    {
        $communes = Commune::all();
        $departements = Departement::all();
        $regions = Region::all();
        $query = Etablissement::where("nom", "like", "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orWhere('sigle', 'like', "%{$this->search}%")
            ->orWhere('reference', 'like', "%{$this->search}%");

        $departementList = optional(optional(optional(auth()->user()->inspecteur)->ia)->departements)->pluck('id');
        $this->departementList = $departementList ? $departementList->toArray() : [];

        $communeList = optional(optional(optional(auth()->user()->inspecteur)->ief)->communes)->pluck('id');
        $this->communeList = $communeList ? $communeList->toArray() : [];


        if (auth()->user()->hasRole(config('constants.roles.ia'))) {
            $query = Etablissement::with(['commune']);
            if ($this->selectedCommune) {
                $query->where("commune_id", $this->selectedCommune);
            } else {
                if ($this->departementList) {
                    $query->whereHas('commune.departement', function ($query) {
                        $query->whereIn('id',  $this->departementList);
                    });
                }
                if ($this->selectedRegion) {
                    $query->whereHas('commune.departement.region', function ($query) {
                        $query->where('id', $this->selectedRegion);
                    });
                }
            }
        }

        if (auth()->user()->hasRole(config('constants.roles.ief'))) {
            if ($this->selectedCommune) {
                $query->where("commune_id", $this->selectedCommune);
            } else {
                if ($this->communeList) {
                    $query->whereIn('commune_id', $this->communeList);
                }
                if ($this->selectedDepartement) {
                    $query->whereHas('commune.departement', function ($query) {
                        $query->where('id', $this->selectedDepartement);
                    });
                }
                if ($this->selectedRegion) {
                    $query->whereHas('commune.departement.region', function ($query) {
                        $query->where('id', $this->selectedRegion);
                    });
                }
            }
        }
        if ($this->selectedCommune && (count($this->departementList) == 0 && count($this->communeList) == 0)) {

            $query = Etablissement::where("commune_id", $this->selectedCommune);
        }

        if ($this->selectedDepartement && (count($this->departementList) == 0 && count($this->communeList) == 0)) {
            $query = Etablissement::with(['commune'])->whereHas('commune.departement', function ($query) {
                $query->where('id', $this->selectedDepartement);
            });
        }
        if ($this->selectedRegion && (count($this->departementList) == 0 && count($this->communeList) == 0)) {
            $query =  Etablissement::with(['commune'])->whereHas('commune.departement.region', function ($query) {
                $query->where('id', $this->selectedRegion);
            });
        }





        $count = $query->count();

        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $etablissements = $query->orderBy('id', 'desc')->offset($this->startLimit)->limit(10)->get();
        if ($this->selectedRegion) {
            $departements = Departement::query()->where('region_id', $this->selectedRegion)->get();
            $communes = Commune::query()->whereIn('departement_id',Arr::pluck($departements, 'id'))->get();
        }
        if ($this->selectedDepartement) {
            $communes = Commune::query()->where('departement_id',$this->selectedDepartement)->get();
        }
        

        return view('livewire.etablissements.liste-etablissement', [
            "etablissements" => $etablissements,
            "departements" => $departements,
            "communes" => $communes,
            "regions" => $regions,
            "count" => $count
        ]);
    }
}
