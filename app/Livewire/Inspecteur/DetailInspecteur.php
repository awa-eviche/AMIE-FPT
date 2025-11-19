<?php

namespace App\Livewire\Inspecteur;

use Livewire\Component;

class DetailInspecteur extends Component
{

    public $inspecteur;
    public $user;

    public function render()
    {
        return view('livewire.inspecteur.detail-inspecteur');
    }
}
