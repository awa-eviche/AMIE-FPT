<?php

namespace App\Livewire\Etablissements;

use Livewire\Component;

class EditEtablissement extends Component
{
    public $etablissement;
    public function render()
    {
        return view('livewire.etablissements.edit-etablissement');
    }
}
