<?php

namespace App\Livewire\Communes;

use Livewire\Component;

class EditCommune extends Component
{
    public $commune;
    public function render()
    {
        return view('livewire.communes.edit-commune');
    }
}
