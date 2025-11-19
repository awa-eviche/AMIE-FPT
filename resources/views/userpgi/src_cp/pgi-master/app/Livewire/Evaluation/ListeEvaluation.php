<?php

namespace App\Livewire\Evaluation;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Evaluation;
use App\Models\Metier;
use Livewire\Component;
use Livewire\WithPagination;

class ListeEvaluation extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedClasse;
    public $selectedMetier;
    public $selectedAnnee;
    public $selectedEvaluationClasse;
    public $selectedEvaluationMetier;
    public $selectedEvaluationAnnee;

    // public $orderField = "";
    // public $orderDirection = "ASC";

    function mount()
    {
        
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
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

    public function setSearch()
    {
    }

    public function render()
    {

        $qry = Evaluation::query();

        if($this->selectedEvaluationClasse){
            $qry->whereHas('evaluation.inscription',  function ($query) {
                $query->where('classe_id', $this->selectedEvaluationClasse);
            });

        }

    
        if ($this->selectedEvaluationMetier) {
            // Utilise une sous-requête EXISTS pour vérifier si la classe a un niveau d'étude avec le 'metier_id' spécifié
            $qry->whereHas('evaluation.inscription.classe.niveau_etude', function ($query) {
                $query->where('metier_id', $this->selectedEvaluationMetier);
            });
        }
        if ($this->selectedEvaluationAnnee) {
            // Utilise une sous-requête EXISTS pour vérifier si la classe a un niveau d'étude avec le 'metier_id' spécifié
            $qry->whereHas('evaluation.inscription.classe', function ($query) {
                $query->where('annee_academique_id', $this->selectedEvaluationAnnee);
            });
        }
        
        $qry->where(function ($query) {
            $query->whereHas('inscription', function ($query) {
                $query->where('classe_id', 'like', '%' . $this->search . '%');
            });
            $query->orWhereHas('inscription.classe.niveau_etude', function ($query) {
                $query->where('metier_id', 'like', '%' . $this->search . '%');
            });
            $query->orWhereHas('inscription.classe', function ($query) {
                $query->where('annee_academique_id', 'like', '%' . $this->search . '%');
            });
        });

        $count = $qry->count();

        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $evaluations = $qry->orderBy('id', 'desc')
        ->offset($this->startLimit)
        ->limit(10)
        ->get();
        $classe = Classe::all();
        $metier = Metier::all();
        $annee_academique = AnneeAcademique::all();

        return view('livewire.evaluation.liste-Evaluation', [
             "evaluations" => $evaluations,
             "classe" => $classe,
             "metier" => $metier,
             "annee_academique" => $annee_academique,
             "count" => $count
        ]);
    }
}