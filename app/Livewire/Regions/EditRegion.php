<?php

namespace App\Livewire\Regions;

use Livewire\Component;

class Editregion extends Component
{
    public $region;
    public function render()
    {
        return view('livewire.regions.edit-region');
    }
}
