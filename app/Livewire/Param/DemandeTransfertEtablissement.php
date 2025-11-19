<?php

namespace App\Livewire\Param;
use Illuminate\Support\Facades\Log;


use Livewire\Component;

class DemandeTransfertEtablissement extends Component
{
    public $entry = [
        "ancienne_adresse_etablissement" => "",
        "nouvelle_adresse_etablissement" => "",
    ];
    public $datasets = [];


    public function mount()
    {
        if(count($this->datasets) > 0)
        {
            $this->entry['ancienne_adresse_etablissement'] = $this->datasets[0]['ancienne_adresse_etablissement'];
            $this->entry['nouvelle_adresse_etablissement'] = $this->datasets[0]['nouvelle_adresse_etablissement'];
        }
    }


    public function onBlur()
    {
        
            if (!empty($this->entry['ancienne_adresse_etablissement']) && !empty($this->entry['nouvelle_adresse_etablissement'])) {
                $this->actionLorsqueChampsModifies();
        }
    }

    public function actionLorsqueChampsModifies()
    {
        $this->dispatch('transfertEtablissement', $this->entry);
    }

    public function render()
    {
       
        if ($this->entry !== null) {
            $this->dispatch('transfertEtablissement', $this->entry);
        }
        return view('livewire.param.demande-transfert-etablissement');
    }
}
