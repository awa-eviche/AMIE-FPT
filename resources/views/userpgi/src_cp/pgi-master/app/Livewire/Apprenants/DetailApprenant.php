<?php

namespace App\Livewire\Apprenants;

use Livewire\Component;

class DetailApprenant extends Component
{

    public $apprenant;
    public $user;

    public function render()
    {
        return view('livewire.apprenant.detail-apprenant');
    }
}