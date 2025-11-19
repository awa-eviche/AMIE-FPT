<?php

namespace App\Livewire\Param;

use Livewire\Component;
use Illuminate\Support\Facades\Log;



class DemandeAutorisationDiriger extends Component
{

    public $entry = [
        "nom" => null,
        "prenom" => null,
    ];

    public $datasets = [];

    public function mount()
    {
        if(count($this->datasets) > 0)
        {
            $this->entry['nom'] = $this->datasets[0]['nom'];
            $this->entry['prenom'] = $this->datasets[0]['prenom'];
        }
    }


    public function onBlur()
    {

        if (!empty($this->entry['nom']) && !empty($this->entry['prenom'])) {
            $this->actionLorsqueChampsModifies();
        }
    }

    public function actionLorsqueChampsModifies()
    {
        $this->dispatch('autorisationDiriger', $this->entry);
    }



    public function render()
    {
        if ($this->entry !== null) {
            $this->dispatch('autorisationDiriger', $this->entry);
        }
        return view('livewire.param.demande-autorisation-diriger');
    }
}
