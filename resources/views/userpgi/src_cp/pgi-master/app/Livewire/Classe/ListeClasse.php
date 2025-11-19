<?php

namespace App\Livewire\Classe;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\Etablissement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ListeClasse extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $selectedFiliere;
    public $selectedMetier;
    public $selectedAnnee;
    public $selectedClasseFiliere;
    public $selectedClasseMetier;
    public $selectedClasseAnnee;
    public $selectedEtablissement;

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
        $this->startLimit += 10 ;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch(){

    }

    public function render()
    {
        if(auth()->user()->can('visualiser_mes_filieres') || auth()->user()->can('edit_mes_filieres'))
        {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id;
                $qry = Classe::where('etablissement_id', $idEtablissement);
            } else {
                $qry = Classe::where([]);
            }
        }
        if (!empty($this->search)) {
            $qry->where(function ($query) {
                $query->where('libelle', 'like', "%{$this->search}%");
            });
        }

        if ($this->selectedFiliere) {
            $qry->where('filiere_id', $this->selectedFiliere);
        }

        if ($this->selectedClasseFiliere) {
            $qry->whereHas('niveau_etude.metier', function ($query) {
                $query->where('filiere_id', $this->selectedClasseFiliere);
            });
        }

        if ($this->selectedMetier) {
            $qry->where('metier_id', $this->selectedMetier);
        }

        if ($this->selectedClasseMetier) {
            $qry->whereHas('niveau_etude', function ($query) {
                $query->where('metier_id', $this->selectedClasseMetier);
            });
        }
        


        if ($this->selectedEtablissement) {
            $qry->where('etablissement_id', $this->selectedEtablissement);
        }

        if ($this->selectedAnnee) {
            $qry->where('annee_academique_id', $this->selectedAnnee);
        }

        if ($this->selectedClasseAnnee) {
            $qry->whereHas('annee_academique', function ($query) {
                $query->where('id', $this->selectedClasseAnnee);
            });
        }

        $count = $qry->count();

        $this->count = $count;
        if ($count == 0) {
            $this->startLimit = 0;
        }

        $classes = $qry->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();

        $metiers = Metier::all();
        $filieres = Filiere::all();
        $annee_academique = AnneeAcademique::all();
        $etablissements = Etablissement::orderBy('nom', 'asc')->get();

        return view('livewire.classe.liste-classe', [
            "classes" => $classes,
            "metiers" => $metiers,
            "filieres" => $filieres,
            "annee_academique" => $annee_academique,
            "etablissements" => $etablissements,
            "count" => $count
        ]);
    }
}