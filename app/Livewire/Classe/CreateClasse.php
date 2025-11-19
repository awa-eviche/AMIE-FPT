<?php

namespace App\Livewire\Classe;


use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\NiveauEtudeEtablissement;
use Livewire\Component;
use Livewire\WithPagination;

class CreateClasse extends Component
{
    use WithPagination;

    public $search = "";
    public $updateMetier = "";
    public $startLimit;
    public $count;
    public $metier = '';
    public $metiers = '';
    public $selectedMetier = '';
    public $niveau = '';
    public $niveaux = [];

    public function updatedMetier($value)
    {

        if ($value) {
            $this->niveaux = NiveauEtude::where('metier_id', $value)->get();
        } else {
            $this->niveaux = [];
        }
    }

    public function render()
    {

        $idEtablissement = optional(auth()->user()->personnel)->etablissement_id;
        if ($idEtablissement !== null) {
            $this->metiers = NiveauEtudeEtablissement::where(['etablissement_id' => $idEtablissement, 'approved' => true])
                ->join('niveau_etudes', 'niveau_etude_etablissements.niveau_etude_id', '=', 'niveau_etudes.id')
                ->join('metiers', 'niveau_etudes.metier_id', '=', 'metiers.id')
                ->pluck('metiers.nom', 'metiers.id');


            $niveaux = [];
            if ($this->metier) {
                $niveaux = NiveauEtude::where('metier_id', $this->metier)->get();
            }

            return view('livewire.classe.create-classe', [

                "niveaux" => $niveaux,
            ]);
        }
    }
}
