<?php

namespace App\Livewire\DroitInscriptions;

use App\Models\Classe;
use App\Models\Competence;
use App\Models\ElementCompetence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Droit extends Component
{
    public $classe;
    public $classes = [];
    public $apprenants = [];
    public $annee_academique_id;
    public $anneeAcademiques;
    public $anneeAcademiqueLabel;

    public $currentClasse = null;
    public $currentApprenant = null;
    public $selectedApprenant;
    public $selectedsemestre1 = '';

    public $competences = [];
    public $evaluations = [];

    public $filtres = [];
    public $filtre = null;

    public $count = 0;
    public $startLimit = 0;
    public $nombreApprenants = 0;

    public function mount()
    {
        $user = auth()->user();

        $this->anneeAcademiques = AnneeAcademique::all();
        $this->annee_academique_id = session()->get('annee_academique_id', '');
        $this->anneeAcademiqueLabel = optional(
            $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)
        )->code;

       
        if ($user->hasRole('formateur') && $user->personnel) {
            $this->classes = Classe::where('modalite', 'APC')
                ->whereHas('formateurs', function ($q) use ($user) {
                    $q->where('personnel_etablissement_id', $user->personnel->id);
                })->get();
        } elseif ($user->hasRole('superadmin')) {
            $this->classes = Classe::where('modalite', 'APC')->get();
        } else {
            $etabId = $user->personnel->etablissement_id ?? null;
            $this->classes = Classe::where('modalite', 'APC')
                ->when($etabId, fn($q) => $q->where('etablissement_id', $etabId))
                ->get();
        }
    }


    public function updatedClasse()
    {
        session()->put('currentClasse', $this->classe);
        $this->currentClasse = Classe::with(['etablissement','niveau_etude.metier.filiere'])
            ->find($this->classe);

        $this->loadApprenants();
        $this->resetSelection();
    }

    public function updatedAnneeAcademiqueId()
    {
        session()->put('annee_academique_id', $this->annee_academique_id);
        $this->anneeAcademiqueLabel = optional(
            $this->anneeAcademiques->firstWhere('id', $this->annee_academique_id)
        )->code;

        $this->loadApprenants();
        $this->resetSelection();
    }


    private function resetSelection()
    {
        $this->selectedApprenant = null;
        $this->currentApprenant = null;
        $this->competences = [];
        $this->evaluations = [];
        $this->filtres = [];
        $this->filtre = null;
        $this->count = 0;
        $this->startLimit = 0;
    }

    public function loadApprenants()
    {
        if (!$this->classe || !$this->annee_academique_id) {
            $this->apprenants = [];
            $this->nombreApprenants = 0;
            return;
        }

        $this->apprenants = Inscription::with('apprenant')
            ->where('classe_id', $this->classe)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->get();

        $this->nombreApprenants = $this->apprenants->count();
    }

   
   
   public function render()
{
    
    $absences = collect();

    if (!empty($this->selectedApprenant)) {
        $inscription = \App\Models\Inscription::find($this->selectedApprenant);

        if ($inscription) {
            $absences = \App\Models\Absence::where('inscription_id', $inscription->id)
                ->orderByDesc('date_absence') 
                ->get();
        }
        
    }

    return view('livewire.droitinscription.droit', [
        'currentClasse'        => $this->currentClasse,
        'currentApprenant'     => $this->currentApprenant,
        'classes'              => $this->classes,
        'classe'               => $this->classe,
        'apprenants'           => $this->apprenants,
       
        'filtres'              => $this->filtres,
        'filtre'               => $this->filtre,
        'anneeAcademiques'     => $this->anneeAcademiques,
        'annee_academique_id'  => $this->annee_academique_id,
        'anneeAcademiqueLabel' => $this->anneeAcademiqueLabel,
        'nombreApprenants'     => $this->nombreApprenants,

    ]);
}

    

}
