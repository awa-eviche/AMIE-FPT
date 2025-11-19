<?php

namespace App\Livewire\Entreprises;

use Livewire\Component;

class DetailEntreprise extends Component
{

    public $entreprise;

    public function render()
    {
        return view('livewire.entreprises.detail-entreprise');
    }
}
