<?php

namespace App\Livewire\Classe;


use App\Models\Metier;
use App\Models\NiveauEtude;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NiveauEtudeEtablissement;


class EditClasse extends Component
{
    use WithPagination;

    public $search = "";

    public $startLimit;
    public $count;
    public $metier = '';
    public $niveau = '';
    public $niveaux = [];
    public $nivx;


    public function mount()
    {
        $this->niveaux =  NiveauEtude::where('metier_id', $this->nivx->metier->id)->get();
    }

    public function academiaNew($value)
    {
        // Utilisez $value pour accéder à la valeur sélectionnée
        if ($value) {
            $this->niveaux = NiveauEtude::where('metier_id', $value)->get();
        } else {
            $this->niveaux = [];
        }
        // Vous pouvez utiliser $value directement pour accéder à la valeur sélectionnée
    }
    public function render()
    {
        // Récupérer tous les métiers
        
        $metiers  = Metier::whereHas('niveaux', function ($query) {
            $query->whereHas('niveauEtudeEtablissement', function ($subQuery) {
                $idEtablissement = optional(auth()->user()->personnel)->etablissement_id;
                $subQuery->where(['etablissement_id' => $idEtablissement , 'approved' => true]);
            });
        })->get();

        // Récupérer les niveaux associés au métier sélectionné
        $niveaux = [];
        if ($this->metier) {
            $niveaux = NiveauEtude::where('metier_id', $this->metier)->get();
        }

        return view('livewire.classe.edit-classe', [
            "metiers" => $metiers,
            "niveaux" => $niveaux,
            "nivx" => $this->nivx
        ]);
    }
}
