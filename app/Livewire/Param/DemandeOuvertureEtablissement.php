<?php

namespace App\Livewire\Param;

use Livewire\Component;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;



class DemandeOuvertureEtablissement extends Component
{
    public $filieres = [];
    public $niveaux = [];
    public $filiereFromBD = [];
    public $niveauFromBD = [];
    public $selectionedFiliere = null;
    public $selectionedNiveau = null;
    public $datasets = [];
    public $filiere = null;
    public $niveau = null;


    public function mount()
    {
        $this->initializeData();
    }

    public function initializeData()
    {
        $this->filiereFromBD = Filiere::all();
        
        //$this->niveauFromBD = NiveauEtude::all();
    }


    public function add()
    {
        $data['filiere'] = Filiere::find($this->filiere);
        $data['niveau'] = NiveauEtude::find($this->niveau);
        array_push($this->datasets, $data);
        $this->dispatch('overtureEtablissement',$this->datasets);
    }


    public function onNiveauChange()
    {
    }

   

    public function onFiliereChange()
    {
        

    }


    function remove(int $index)
    {
        
        if (isset($this->datasets[$index - 1])) {
            unset($this->datasets[$index - 1]);  
            $this->datasets = array_values($this->datasets);
            return true;
        } else {
            return false;
        }
    }





    public function render()
    {
        if ($this->filiere!=null) {

          //  Log::info($this->filiere);
            $metier_id =Arr::pluck(Filiere::query()->find($this->filiere)->metiers,'id') ;
          //  Log::info($metier_id);
            $this->niveauFromBD  = NiveauEtude::query()->whereIn('metier_id',$metier_id)->orderBy('nom','desc')->get()->unique('id');
         //   Log::info($this->niveauFromBD);                   
        }
        if(count($this->datasets))
        {
            $this->dispatch('overtureEtablissement',$this->datasets);
        }
        
        return view('livewire.param.demande-ouverture-etablissement');
    }
}
