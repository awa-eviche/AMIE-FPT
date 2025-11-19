<?php

namespace App\Livewire\Departements;

use Livewire\Component;

class DetailDepartement extends Component
{

    public $departement;

    public function render()
    {
        return view('livewire.departements.detail-departement');
    }
}
