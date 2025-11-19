<?php

namespace App\Livewire\NiveauEtudeEtablissements;

use App\Models\Etablissement;
use App\Models\NiveauEtudeEtablissement;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class ListeNiveauEtudeEtablissement extends Component
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
        $niveauetudeetablissements = [];
        $count = 0; 
        $les_metiers = [];

        if (auth()->user()->can('visualiser_mes_filieres') || auth()->user()->can('edit_mes_filieres')) {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id;
                $qry = NiveauEtudeEtablissement::where('etablissement_id', $idEtablissement);
        
                if ($this->search) { 
                    $qry->whereHas('filiere', function ($query) {
                        $query->where('nom', 'like', "%{$this->search}%"); 
                    });
                }
            
                if ($qry) { 
                    $count = $qry->count(); 

                    $niveauetudeetablissements = $qry->where('isDeleted', false)->orderBy('id', 'desc')
                        // ->offset($this->startLimit)
                        // ->limit(10)
                        ->get();
                }
            }
        }
        $f0=""; $ix=0;
        foreach($niveauetudeetablissements as $niv) {
            $nivE = NiveauEtude::find($niv->niveau_etude_id);
            if($nivE->metier_id != $f0) {
                $metier = Metier::find($nivE->metier_id);
                if(!isset($les_metiers[$metier->nom]))$les_metiers[$metier->nom] = []; 
                $les_metiers[$metier->nom][] = $nivE; 
            }
        }

    
        return view('livewire.niveauetudeetablissement.liste-niveauetudeetablissement', [
            "niveauetudeetablissements" => $niveauetudeetablissements,
            "les_metiers" => $les_metiers,
            "count" => $count
        ]);
    }
    
}
