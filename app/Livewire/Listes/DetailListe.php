<?php

namespace App\Livewire\Listes;

use Livewire\Component;

class DetailListe extends Component
{

    public $liste;

    public function render()
    {
        return view('livewire.listes.detail-liste');
    }
}
