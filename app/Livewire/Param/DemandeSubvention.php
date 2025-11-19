<?php

namespace App\Livewire\Param;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Log;



use Livewire\Component;

class DemandeSubvention extends Component
{
    public $anneeAcademiqueBDs = [];
    public $entry = ["annee_academique_id" => null];
    public $datasets = [];


    public function mount()
    {
        $this->initializeData();
        if(count($this->datasets) > 0)
        {
            $this->entry['annee_academique_id'] = $this->datasets[0]['annee_academique_id'];
        }
    }


    public function onAnneeAcademiqueChange()
    {
        
            if (!empty($this->entry['annee_academique_id'])) {
                $this->actionLorsqueChampsModifies();
        }
    }

    public function actionLorsqueChampsModifies()
    {
        $this->dispatch('subvention', $this->entry);
    }


    public function initializeData()
    {
        $this->anneeAcademiqueBDs = AnneeAcademique::where('is_open', true)->get();
    }


    public function render()
    {
        $this->entry ? $this->dispatch('subvention',$this->entry) : null;
        return view('livewire.param.demande-subvention');
    }
}
