<?php

namespace App\Livewire;

use Livewire\Component;

class ShowEtatWorkflow extends Component
{
    public $etatWorkflow;

    public function render()
    {
        return view('livewire.show-etat-workflow');
    }
}
