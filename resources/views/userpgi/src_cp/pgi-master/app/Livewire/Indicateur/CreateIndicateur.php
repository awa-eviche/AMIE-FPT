<?php

namespace App\Livewire\Indicateur;

use App\Models\AnneeAcademique;
use App\Models\TypeIndicateur;
use Livewire\Component;

class CreateIndicateur extends Component
{
    public function render()
    {
        $typeIndicateurs = TypeIndicateur::query()->get();
        $annees = AnneeAcademique::query()->get();
        return view('livewire.indicateur.create-indicateur',compact('typeIndicateurs','annees'));
    }
}
