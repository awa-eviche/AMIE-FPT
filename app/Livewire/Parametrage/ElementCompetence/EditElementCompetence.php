<?php

namespace App\Livewire\Parametrage\ElementCompetence;

use App\Models\Metier;
use App\Models\Competence;
use App\Models\NiveauEtude;
use App\Models\ElementCompetence;
use Livewire\Component;

class EditElementCompetence extends Component
{
    public $metier = '';
    public $niveau = '';
    public $competence = '';
    
    public $competences = [];
    public $niveauEtudes = [];

    public $elementCompetence;

    public function mount(ElementCompetence $elementCompetence)
    {
        $this->elementCompetence = $elementCompetence;

        $this->metier = $elementCompetence->metier_id;
        $this->niveau = $elementCompetence->niveau_etude_id;
        $this->competence = $elementCompetence->competence_id;

        // Précharger les niveaux d’étude liés à ce métier
        $this->niveauEtudes = NiveauEtude::whereHas('competences', function ($query) {
            $query->where('metier_id', $this->metier);
        })->get();

        // Précharger les compétences liées au métier et niveau
        $this->competences = Competence::where('metier_id', $this->metier)
                                       ->where('niveau_etude_id', $this->niveau)
                                       ->get();
    }

    public function updatedMetier($value)
    {
        $this->niveau = '';
        $this->competence = '';
        $this->competences = [];

        $this->niveauEtudes = NiveauEtude::whereHas('competences', function ($query) use ($value) {
            $query->where('metier_id', $value);
        })->get();
    }

    public function updatedNiveau($value)
    {
        if (!empty($this->metier) && !empty($value)) {
            $this->competences = Competence::where('metier_id', $this->metier)
                                           ->where('niveau_etude_id', $value)
                                           ->get();
        } else {
            $this->competences = [];
        }

        $this->competence = '';
    }

    public function render()
    {
        return view('livewire.parametrage.elementcompetence.edit-elementcompetence', [
            'metiers' => Metier::all(),
            'competences' => $this->competences,
            'niveauEtudes' => $this->niveauEtudes,
        ]);
    }
}
