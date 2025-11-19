<?php

namespace App\Livewire\Departements;

use Livewire\Component;

class EditDepartement extends Component
{
    public $departement;
    public function render()
    {
        return view('livewire.departements.edit-departement');
    }
}
