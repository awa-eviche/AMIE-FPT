<?php

namespace App\Livewire\Entreprises;

use Livewire\Component;

class EditEntreprise extends Component
{
    public $entreprise;
    public function render()
    {
        return view('livewire.entreprises.edit-entreprise');
    }
}
