<?php

namespace App\Livewire\Evaluation;

use App\Models\Apprenant;
use App\Models\Matiere;
use App\Models\Inscription;
use App\Models\Metier;
use Livewire\Component;
use Livewire\WithPagination;

class CreateEvaluation extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;
    public $metier = '';
    public $inscription = '';
    public $apprenant = '';
    public $apprenants = [];
    public $matiere = '';
    public $matieres = [];

  

    public function updatedMetier($value)
    {

        if ($value) {
            $this->matieres = Matiere::where('metier_id', $value)->get();
        } else {
            $this->matieres = [];
        }
    }

    public function updatedApprenant($val)
    {

        if ($val) {
            $this->apprenants = Apprenant::where('inscription_id', $val)->get();
        } else {
            $this->apprenants = [];
        }
    }

    public function render()
    {
        // Récupérer tous les métiers
        $metiers = Metier::all();

        // Récupérer toutes les inscriptions
        $inscriptions = Inscription::all();

        // Récupérer les matieres associés au métier sélectionné
        $matieres = [];
        if ($this->metier) {
            $matieres = Matiere::where('metier_id', $this->metier)->get();
        }

        $apprenants = [];
        if ($this->inscription) {
            $apprenants = Apprenant::where('inscription_id', $this->apprenant)->get();
        }


        return view('livewire.evaluation.create-evaluation', [
            "metiers" => $metiers,
            "matieres" => $matieres,
            "apprenants" => $apprenants,
            "inscriptions" => $inscriptions,

        ]);
    }
}
