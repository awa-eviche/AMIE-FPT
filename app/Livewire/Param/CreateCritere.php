<?php

namespace App\Livewire\Param;

use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Competence;
use App\Models\ElementCompetence;
use Livewire\Component;

class CreateCritere extends Component
{
    // Propriétés
    public $metier = '';
    public $niveau = '';
    public $competence = '';
    public $element = '';

    public $niveaux = [];
    public $competences = [];
    public $elements = [];

    // Lorsque le métier change
    public function updatedMetier($value)
    {
        $this->niveau = '';
        $this->competence = '';
        $this->element = '';
        $this->niveaux = $value ? NiveauEtude::where('metier_id', $value)->get() : [];
        $this->competences = [];
        $this->elements = [];
    }

    // Lorsque le niveau change
    public function updatedNiveau($value)
    {
        $this->competence = '';
        $this->element = '';
        $this->competences = $value ? Competence::where('niveau_etude_id', $value)->get() : [];
        $this->elements = [];
    }

    // Lorsque la compétence change
    public function updatedCompetence($value)
    {
        $this->element = '';
        $this->elements = $value ? ElementCompetence::where('competence_id', $value)->get() : [];
    }

    public function render()
    {
       // $metiers = Metier::all();
       $metiers = Metier::orderBy('nom', 'asc')->get();
       
        return view('livewire.param.create-critere', [
            'metiers'     => $metiers,
            'niveaux'     => $this->niveaux,
            'competences' => $this->competences,
            'elements'    => $this->elements,
        ]);
    }
}
