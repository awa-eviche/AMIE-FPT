<?php

namespace App\Livewire\FiliereEtablissements;

use App\Models\Etablissement;
use App\Models\FiliereEtablissement;
use App\Models\Filiere;
use Livewire\Component;
use Livewire\WithPagination;

class ListeFiliereEtablissement extends Component
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
        $qry = null; 
        $filiereetablissements = [];
        $count = 0; 

        if (auth()->user()->can('visualiser_mes_filieres') || auth()->user()->can('edit_mes_filieres')) {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id;
                $qry = FiliereEtablissement::where('etablissement_id', $idEtablissement);
        
                if ($this->search) { 
                    $qry->whereHas('filiere', function ($query) {
                        $query->where('nom', 'like', "%{$this->search}%"); 
                    });
                }
            
                if ($qry) { 
                    $count = $qry->count(); 

                    $filiereetablissements = $qry->orderBy('id', 'desc')
                        ->offset($this->startLimit)
                        ->limit(10)
                        ->get();
                }
            }
        }
    
        return view('livewire.filiereetablissement.liste-filiereetablissement', [
            "filiereetablissements" => $filiereetablissements,
            "count" => $count
        ]);
    }
    
}
