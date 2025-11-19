<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;

class DetailEtablissement extends Component
{

    public $etablissement;
    public $user;

    public function render()
    {
        return view('livewire.etablissements.detail-etablissement');
    }
}
