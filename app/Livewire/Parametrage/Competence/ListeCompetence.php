<?php

namespace App\Livewire\Parametrage\Competence;

use App\Models\Metier;
use App\Models\Competence;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;

class ListeCompetence extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;
    public $selectedCompetence;
    public $selectedCompetenceMetier;
    public $selectedCompetenceNiveau;

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
        ]);
    }

    function next()
    {
        $this->startLimit += 10;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function updatedSelectedCompetenceMetier($value)
    {
        // Réinitialiser le niveau quand le métier change
        $this->selectedCompetenceNiveau = '';
    }

    public function render()
    {
        $qry = Competence::query();

        if ($this->selectedCompetence) {
            $qry->where('id', $this->selectedCompetence);
        }

        if ($this->selectedCompetenceMetier) {
            $qry->where('metier_id', $this->selectedCompetenceMetier);
        }

        if ($this->selectedCompetenceNiveau) {
            $qry->where('niveau_etude_id', $this->selectedCompetenceNiveau);
        }

        $qry->where(function ($query) {
            $query->where("nom", "like", "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%");
        });

        $count = $qry->count();
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $competences = $qry->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();

      //  $metiers = Metier::all();
$metiers = Metier::orderBy('nom', 'asc')->get();

        // ✅ Filtrer les niveaux selon le métier sélectionné
        $niveau = $this->selectedCompetenceMetier
            ? NiveauEtude::where('metier_id', $this->selectedCompetenceMetier)->get()
            : collect(); // vide si aucun métier sélectionné

        return view('livewire.parametrage.competence.liste-competence', [
            "competences" => $competences,
            "metiers" => $metiers,
            "niveau" => $niveau,
            "count" => $count,
        ]);
    }
}
