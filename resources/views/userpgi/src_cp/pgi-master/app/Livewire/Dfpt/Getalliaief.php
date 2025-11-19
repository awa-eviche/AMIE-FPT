<?php

namespace App\Livewire\DFPT;

use App\Models\Ia;
use Livewire\Component;

class Getalliaief extends Component
{
    public function ia(){
        $ia =  Ia::query();
        dd($ia);
    }
    public function ief(){
        
    }
    public function render()
    {
        
        return view('livewire.dfpt.getalliaief');
    }
}
