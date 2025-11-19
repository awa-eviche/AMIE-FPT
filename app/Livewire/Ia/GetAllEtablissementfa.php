<?php

namespace App\Livewire\Ia;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GetAllEtablissement extends Component
{
    use WithPagination;
    public $count;
    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedClasse;
    public $selectedRegion;
    public $selectedDepartemant;
    public $regions;
    public $departements;
    public $communes;
    public $filieres;
    public $selectedFiliere;
    public $selectedNiveau;
    public $niveaux;
    public $classes;
    public function resetAll(){
        $this->selectedsexe = "";
        $this->search = "";
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
        if(Auth::user()->inspecteur()->first()!==null){
            $this->departements =  Auth::user()->inspecteur()->first()?->ia()->first()?->departements()->get();
            $this->communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements,'id') )->get();
            $allEtablissements = Etablissement::query('etablissements')
                ->join('communes','communes.id','=','etablissements.commune_id')
                ->join('classes','classes.etablissement_id','=','etablissements.id')
                ->join('niveau_etudes','niveau_etudes.id','=','classes.niveau_etude_id')
                ->join('metiers','metiers.id','=','niveau_etudes.metier_id')
                ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                // ->join('annee_academiques','annee_academiques.id','=','classes.annee_academique_id')              Â 
                ->Where(function($query) {
                    if ($this->selectedCommune) {                        
                        $query->Where('etablissements.commune_id',$this->selectedCommune);
                    }else {
                        $communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements,'id') )->get();
                        $query->WhereIn('etablissements.commune_id',Arr::pluck($communes,'id'));
                    }
                    if ($this->selectedNiveau) {
                        $query->Where('niveau_etudes.id',$this->selectedNiveau);
                    }
                    if ($this->selectedClasse) {
                        $query->Where('classes.id',$this->selectedClasse);
                    }
                    if ($this->selectedFiliere) {
                        $query->Where('filieres.id',$this->selectedFiliere);
                    }
                    if ($this->selectedRegion) {
                        $this->departements = Departement::query()->where('region_id', $this->selectedRegion)->get();
                        $communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements, 'id'))->get();
                        $query->WhereIn('etablissements.commune_id',Arr::pluck($communes,'id'));
                    }
                    if ($this->selectedDepartemant) {
                        $communes = Commune::query()->where('departement_id',$this->selectedDepartemant)->get();
                        $query->WhereIn('etablissements.commune_id',Arr::pluck($communes,'id'));
                    }else {
                        $communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements,'id') )->get();
                        $query->WhereIn('etablissements.commune_id',Arr::pluck($communes,'id'));
                    }
                    
                    
                    
                    $query->where('etablissements.is_active', 1);
                                        
                });
                $this->count = $allEtablissements->select('etablissements.*')->distinct(['etablissements.id'])->count();
                $this->niveaux = $allEtablissements->select('niveau_etudes.*')->get()->unique('id');
                $this->classes = $allEtablissements->select('classes.*')->get();
                $this->filieres = $allEtablissements->select('filieres.*')->get()->unique('id');
                if($this->selectedDepartemant){
                    $this->communes = Commune::query()->where('departement_id',$this->selectedDepartemant)->get();
                }
                
            $etablissements = $allEtablissements
                            ->select('etablissements.*','communes.libelle as nameCommune')->distinct(['etablissements.id'])->paginate(10);
            
            return view('livewire.ia.get-all-etablissement',compact('etablissements'));
        }else {
            $etablissements = null;
            return view('livewire.ia.get-all-etablissement',compact('etablissements'));
        }
        
    }
}
