<?php

namespace App\Livewire\Ia;

use App\Models\Apprenant;
use App\Models\Commune;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GetAllApprenants extends Component
{
    use WithPagination; 
    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedClasse;
    public $communes;
    public $etablissements;
    public $niveaux;
    public $classes;
    public $count;
    public $selectedNiveau;
    public $selectedFiliere;
    public $filieres;
    public $regions;
    public $departements;
    public $selectedRegion;
    public $selectedDepartemant;
    public function setSearch(){
    }
    public function resetAll(){
        $this->selectedsexe = "";
        $this->search = "";
        $this->selectedDepartemant="";
        $this->selectedRegion="";
        $this->selectedEtablissement =  "";
        $this->selectedClasse =  "";
        $this->selectedCommune =  "";
        $this->selectedNiveau =  "";
        $this->selectedFiliere="";

    }
    public function render()
    {
        if(Auth::user()->inspecteur()->first()!==null){
            $this->departements =  Auth::user()->inspecteur()->first()->ia()->first()->departements()->get();
            $this->communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements,'id') )->get();
            $apprenantsAll = Apprenant::query('apprenants')
                ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
                ->join('classes','classes.id','=','inscriptions.classe_id')
                ->join('etablissements','etablissements.id','=','classes.etablissement_id')
                ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
                ->join('metiers','metiers.id','=','niveaux.metier_id')
                ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                
                
                ->Where(function($query) {
                    $query->where('apprenants.sexe','like', '%'. $this->selectedsexe.'%');
                    if ($this->selectedCommune) {
                        
                        $query->Where('apprenants.commune_id',$this->communes);
                    }
                    if ($this->selectedNiveau) {
                        $query->Where('niveaux.id',$this->selectedNiveau);
                    }
                    if ($this->selectedClasse) {
                        $query->Where('classes.id',$this->selectedClasse);
                    }
                    if ($this->selectedFiliere) {
                        $query->Where('filieres.id',$this->selectedFiliere);
                    }
                    if ($this->selectedRegion) {
                        $communes = Commune::query()->whereIn('departement_id',Arr::pluck($this->departements, 'id'))->get();
                        $query->WhereIn('apprenants.commune_id',Arr::pluck($communes,'id'));
                    }

                    if ($this->selectedDepartemant) {
                        $communes = Commune::query()->where('departement_id',$this->selectedDepartemant)->get();
                        $query->WhereIn('apprenants.commune_id',Arr::pluck($communes,'id'));
                    }else{
                        $query->WhereIn('apprenants.commune_id',Arr::pluck($this->communes,'id'));
                    }
                    
                    $query->where('apprenants.isDeleted', 0);
                                        
                });
                    
                
                $this->niveaux = $apprenantsAll->select('niveaux.*')->get()->unique('id');
                $this->classes = $apprenantsAll->select('classes.*')->get()->unique('id');
                $this->count = $apprenantsAll->count();
                $apprenants =  $apprenantsAll->select('apprenants.*','niveaux.nom as niveauName','classes.libelle as classeName','etablissements.sigle as etablissementSigle')
                                            ->distinct(['apprenants.id'])
                                            ->paginate(50);
                $this->filieres = $apprenantsAll->select('filieres.*')->get()->unique('id');
            
            return view('livewire.ia.getallapprenants',compact('apprenants'));
    }else{
        $apprenants = null;
        return view('livewire.ia.getallapprenants',compact('apprenants'));
    }
}
}
