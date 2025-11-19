<?php

namespace App\Livewire\Apprenants;

use Livewire\Component;

class EditApprenant extends Component
{
    public $apprenant;
    public function render()
    {
        return view('livewire.apprenant.edit-apprenant');
    }
}