<?php

namespace App\Livewire\Param;

use Livewire\Component;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Competence;
use App\Models\ElementCompetence;
use App\Models\Critere;

class EditCritere extends Component
{
    public $critereId;
    public $libelle;

    public $metiers = [];
    public $niveaux = [];
    public $competences = [];
    public $elements = [];

    public $selectedMetier = '';
    public $selectedNiveau = '';
    public $selectedCompetence = '';
    public $selectedElement = '';


    public function mount($id)
    {
        $this->critereId = $id;
        $critere = Critere::with('elementCompetence.competence.niveau_etude.metier')->findOrFail($id);

        
        $this->metiers = Metier::orderBy('nom')->get();

       
        $this->selectedMetier = $critere->elementCompetence->competence->niveau_etude->metier_id ?? '';

        $this->niveaux = NiveauEtude::where('metier_id', $this->selectedMetier)->get();

        $this->selectedNiveau = $critere->elementCompetence->competence->niveau_etude_id ?? '';
        $this->competences = Competence::where('niveau_etude_id', $this->selectedNiveau)->get();

        $this->selectedCompetence = $critere->elementCompetence->competence_id ?? '';
        $this->elements = ElementCompetence::where('competence_id', $this->selectedCompetence)->get();

        $this->selectedElement = $critere->element_competence_id ?? '';
        $this->libelle = $critere->libelle ?? '';
    }

   
    public function updatedSelectedMetier($metierId)
    {
        $this->niveaux = NiveauEtude::where('metier_id', $metierId)->get();
        $this->selectedNiveau = $this->selectedCompetence = $this->selectedElement = '';
        $this->competences = $this->elements = [];
    }

    public function updatedSelectedNiveau($niveauId)
    {
        $this->competences = Competence::where('niveau_etude_id', $niveauId)->get();
        $this->selectedCompetence = $this->selectedElement = '';
        $this->elements = [];
    }

    public function updatedSelectedCompetence($competenceId)
    {
        $this->elements = ElementCompetence::where('competence_id', $competenceId)->get();
        $this->selectedElement = '';
    }

  
    public function update()
    {
        $this->validate([
            'selectedElement' => 'required',
            'libelle' => 'required|string|max:255',
        ]);

        $critere = Critere::findOrFail($this->critereId);
        $critere->element_competence_id = $this->selectedElement;
        $critere->libelle = $this->libelle;
        $critere->save();

        session()->flash('success', ' Le critère a été mis à jour avec succès.');
        return redirect()->route('critere.index');
    }

    public function render()
    {
        return view('livewire.param.edit-critere');
    }
}
