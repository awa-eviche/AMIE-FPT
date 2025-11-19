<?php

namespace App\Livewire\Parametrage\ElementCompetence;

use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Competence;
use App\Models\ElementCompetence;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // ✅ C’est ici que tu fais la correction
class ElementCompetenceMultiFixed extends Component
{
    public $metier_id = '';
    public $niveau_etude_id = '';
    public $competence_id = '';

    public $rows = [];


    public $niveaux = [];
public $competences = [];

public function updatedMetierId($value)
{
    // Quand un métier est sélectionné → charger les niveaux associés
    $this->niveau_etude_id = '';
    $this->competence_id = '';
    $this->niveaux = NiveauEtude::whereHas('competences', function ($query) use ($value) {
        $query->where('metier_id', $value);
    })->get();

    $this->competences = []; // on vide les compétences
}

public function updatedNiveauEtudeId($value)
{
    // Quand un niveau est sélectionné → charger les compétences liées au métier et niveau
    if (!empty($this->metier_id) && !empty($value)) {
        $this->competences = Competence::where('metier_id', $this->metier_id)
            ->where('niveau_etude_id', $value)
            ->get();
    } else {
        $this->competences = [];
    }
}

    public function mount()
    {
        $this->addRow();
    }

    public function addRow()
    {
        $this->rows[] = [
            'code' => '',
            'nom' => '',
            'description' => '',
        ];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function submit()
    {
        $this->validate([
            'metier_id' => 'required|exists:metiers,id',
            'niveau_etude_id' => 'required|exists:niveau_etudes,id',
            'competence_id' => 'required|exists:competences,id',
        ]);

        foreach ($this->rows as $row) {
            validator($row, [
                'code' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
            ])->validate();

            ElementCompetence::create([
                'code' => $row['code'],
                'nom' => $row['nom'],
                'description' => $row['description'],
                'metier_id' => $this->metier_id,
                'niveau_etude_id' => $this->niveau_etude_id,
                'competence_id' => $this->competence_id,
            ]);
        }

        session()->flash('success', 'Tous les éléments ont été enregistrés.');
        return redirect()->route('elementcompetence.index');
    }

    public function render()
    {
        return view('livewire.parametrage.element-competence.element-competence-multi-fixed', [
            'metiers' => Metier::all(),
            'niveaux' => $this->niveaux,
            'competences' => $this->competences,
        ]);
    }
}
