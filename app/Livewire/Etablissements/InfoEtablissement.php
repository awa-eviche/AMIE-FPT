<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;

class InfoEtablissement extends Component
{

    public $etablissement;
    public function render()
    {
        return view('livewire.etablissements.info-etablissement');
    }
}
