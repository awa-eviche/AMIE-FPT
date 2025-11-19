<?php

namespace App\Livewire\Communes;

use Livewire\Component;

class DetailCommune extends Component
{

    public $commune;

    public function render()
    {
        return view('livewire.communes.detail-commune');
    }
}
