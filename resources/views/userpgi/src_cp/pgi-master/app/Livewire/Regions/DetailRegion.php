<?php

namespace App\Livewire\Regions;

use Livewire\Component;

class DetailRegion extends Component
{

    public $region;

    public function render()
    {
        return view('livewire.regions.detail-region');
    }
}
