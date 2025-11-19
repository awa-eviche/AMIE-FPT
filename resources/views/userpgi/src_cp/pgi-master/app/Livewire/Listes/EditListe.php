<?php

namespace App\Livewire\Listes;

use Livewire\Component;

class EditListe extends Component
{
    public $liste;
    public function render()
    {
        return view('livewire.listes.edit-liste');
    }
}
