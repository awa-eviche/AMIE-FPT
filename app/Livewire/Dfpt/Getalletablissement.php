<?php

namespace App\Livewire\DFPT;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Ia;
use App\Models\Ief;
use App\Models\Region;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Getalletablissement extends Component
{
    public $count;
    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedIA;
    public $selectedIef;
    public $selectedClasse;
    public $selectedRegion;
    public $selectedDepartemant;
    public $regions;
    public $departements;
    public $filieres;
    public $ias;
    public $iefs;
    public $selectedFiliere;

    public $selectedNiveau;
    public function resetAll(){
        $this->selectedsexe = "";
        $this->search = "";
        $this->selectedIA = "";
        $this->selectedEtablissement =  "";
        $this->selectedIef =  "";
        $this->selectedEtablissement =  "";
        $this->selectedDepartemant="";
        $this->selectedRegion="";
        $this->selectedClasse =  "";
        $this->selectedCommune =  "";
        $this->selectedNiveau =  "";
        $this->selectedFiliere="";

    }

    public function render()
    {
        $this->regions = Region::query()->get();
        $allEtablissements = Etablissement::query()
        ->join('communes', 'communes.id', '=', 'etablissements.commune_id')
        ->join('classes', 'classes.etablissement_id', '=', 'etablissements.id')
        ->join('niveau_etudes', 'niveau_etudes.id', '=', 'classes.niveau_etude_id')
        ->join('metiers', 'metiers.id', '=', 'niveau_etudes.metier_id')
        ->join('filieres', 'filieres.id', '=', 'metiers.filiere_id')
        ->join('inscriptions', 'inscriptions.classe_id', '=', 'classes.id')
        ->join('annee_academiques', 'annee_academiques.id', '=', 'inscriptions.annee_academique_id')
        ->where(function($query) {
            if ($this->selectedCommune) {
                $query->where('etablissements.commune_id', $this->selectedCommune);
            }
            if ($this->selectedNiveau) {
                $query->where('niveau_etudes.id', $this->selectedNiveau);
            }
            if ($this->selectedClasse) {
                $query->where('classes.id', $this->selectedClasse);
            }
            if ($this->selectedFiliere) {
                $query->where('filieres.id', $this->selectedFiliere);
            }
            if ($this->selectedRegion) {
                $this->departements = Departement::where('region_id', $this->selectedRegion)->get();
                $communes = Commune::whereIn('departement_id', Arr::pluck($this->departements, 'id'))->get();
                $query->whereIn('etablissements.commune_id', Arr::pluck($communes, 'id'));
            }
            if ($this->selectedDepartemant) {
                $communes = Commune::where('departement_id', $this->selectedDepartemant)->get();
                $query->whereIn('etablissements.commune_id', Arr::pluck($communes, 'id'));
            }
            if ($this->selectedIA) {
                $ias = Ia::find($this->selectedIA)?->departements ?? collect();
                $communes = Commune::whereIn('departement_id', Arr::pluck($ias, 'id'))->get();
                $query->whereIn('etablissements.commune_id', Arr::pluck($communes, 'id'));
            }
            if ($this->selectedIef) {
                $communes = Ief::find($this->selectedIef)?->communes ?? collect();
                $query->whereIn('etablissements.commune_id', Arr::pluck($communes, 'id'));
            }
    
            // Exemple si tu veux filtrer une année précise :
            // if ($this->selectedAnneeAcademiqueId) {
            //     $query->where('inscriptions.annee_academique_id', $this->selectedAnneeAcademiqueId);
            // }
    
            $query->where('etablissements.is_active', 1);
        });
    
        $this->count = $allEtablissements->select('etablissements.*')->distinct(['etablissements.id'])->count();
        $communes = $allEtablissements->select('communes.*')->get()->unique('id');
        $niveaux = $allEtablissements->select('niveau_etudes.*')->get()->unique('id');
        $classes = $allEtablissements->select('classes.*')->get();
        $this->filieres = $allEtablissements->select('filieres.*')->get()->unique('id');
        if ($this->selectedRegion || $this->selectedDepartemant) {
            if ($this->selectedRegion ) {
                $this->departements = Departement::query()->where('region_id', $this->selectedRegion)->get();
                $iaId = DB::table('departement_ias')->where('departement_id', Arr::pluck($this->departements, 'id'))->get();
                $this->ias =Ia::query()->where('id',Arr::pluck($iaId, 'id'))->get();
                $communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements, 'id'))->get();
                $iefId = DB::table('commune_iefs')->where('commune_id', Arr::pluck($communes, 'id'))->get();
                $this->iefs = Ief::query()->where('id',Arr::pluck($iefId,'id'))->get();
            }
            if($this->selectedDepartemant){
                $communes = Commune::query()->where('departement_id',$this->selectedDepartemant)->get();
                $iefId = DB::table('commune_iefs')->where('commune_id', Arr::pluck($communes, 'id'))->get();
                $this->iefs = Ief::query()->where('id',Arr::pluck($iefId,'id'))->get();
            }
            if($this->selectedDepartemant){
                $communes = Commune::query()->where('departement_id',$this->selectedDepartemant)->get();
            }
            
        }else {
            $this->departements = Departement::query()->get();
            $this->ias = Ia::query()->get();
            $this->iefs = Ief::query()->get();
        }
        $etablissements =   $allEtablissements
                        ->select('etablissements.*','communes.libelle as nameCommune')->distinct(['etablissements.id'])->paginate(10);
        return view('livewire.dfpt.getalletablissement',compact('etablissements','communes','niveaux','classes'));
    }
}
