<?php

namespace App\Livewire\Param;

use Livewire\Component;

class DemandeChangementDenomination extends Component
{
    public $entry = [
        "ancienne_denomination_etablissement" => null,
        "nouvelle_denomination_etablissement" => null,
    ];

    public $datasets = [];

    public function mount()
    {
        if(count($this->datasets) > 0)
        {
            $this->entry['ancienne_denomination_etablissement'] = $this->datasets[0]['ancienne_denomination_etablissement'];
            $this->entry['nouvelle_denomination_etablissement'] = $this->datasets[0]['nouvelle_denomination_etablissement'];
        }
    }

    public function onBlur()
    {

        if (!empty($this->entry['ancienne_denomination_etablissement']) && !empty($this->entry['ancienne_denomination_etablissement'])) {
            $this->actionLorsqueChampsModifies();
        }
    }


    public function actionLorsqueChampsModifies()
    {
        $this->dispatch('transfertEtablissement', $this->entry);
    }
    public function render()
    {
        $this->entry ? $this->dispatch('changementDenomination', $this->entry) : null;
        return view('livewire.param.demande-changement-denomination');
    }
}
