<?php

namespace App\Livewire\Demandes;

use App\Models\Demande;
use App\Models\TypeDemande;
use App\Services\WorkflowTools;
use Livewire\Component;
use Livewire\WithPagination;

class ListeDemande extends Component
{
    use WithPagination;
    private WorkflowTools $workflowTools;


    public $search = "";
    // public $statusDemande = null;
    public $statusDemandeFiltre = "";
    public $typeDemandeFiltreId = 0;
    public $myState = null;
    public bool $filterByMyState = false;
    public $orderField = "id";
    public $orderDirection = "DESC";
    public $etablissementId = null;

    public function boot(
        WorkflowTools $workflowTools
    ){
        $this->workflowTools = $workflowTools;
    }
    public function mount(){
        $this->myState = $this->workflowTools->getAccessibleEtats(auth()->user());
    }


    public function setTypeDemandeFiltreId($typeDemandeId){
        $this->typeDemandeFiltreId = $typeDemandeId;
    }


    public function toggleFilterByMyState(){
        $this->filterByMyState = !$this->filterByMyState;
    }

    public function setStatusDemandeFiltre($status){
        $this->statusDemandeFiltre = $status;
    }

    public function resetAll(){
        $this->search = "";
        $this->resetPage();
        $this->resetFilters();
    }

    public function setSearch(){
        $this->resetPage();
        $this->resetFilters();
    }

    public function resetFilters(){
        // $this->search = "";
        $this->statusDemandeFiltre = "";
        $this->typeDemandeFiltreId = 0;
        $this->filterByMyState = false;
    }

    public function setOrderField(string $field){
        if($field == $this->orderField){
            $this->orderDirection = $this->orderDirection == "ASC" ? "DESC" : "ASC";
        }else {
            $this->orderField = $field;
            $this->orderDirection = "ASC";
            // $this->reset("orderDirection");
        }
    }

    public function updating($name, $value){
        if($name == "search"){
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.demandes.liste-demande', [
            "demandes" => Demande::join('etablissements', 'demandes.etablissement_id', '=', 'etablissements.id')
            ->join('type_demandes', 'demandes.type_demande_id', '=', 'type_demandes.id')
            ->join('etat_workflows', 'demandes.etat_id', '=', 'etat_workflows.id')
            ->where(function ($query) {
                $query->where('etablissements.nom', 'like', "%{$this->search}%")
                    ->orWhere('demandes.libelle', 'like', "%{$this->search}%")
                    ->orWhere('type_demandes.libelle', 'like', "%{$this->search}%")
                    ->orWhere('etat_workflows.libelle', 'like', "%{$this->search}%");
            })
            ->where(function ($query) {
                $query->where('etat_workflows.status', 'like', "%{$this->statusDemandeFiltre}%");
            })->when($this->typeDemandeFiltreId != 0, function ($query) {
                $query->where('type_demandes.id',$this->typeDemandeFiltreId);
            })->when($this->filterByMyState, function ($query) {
                $query->whereIn('etat_workflows.id',$this->myState->pluck('id'));
            })
            ->when($this->orderField, function ($query) {
                $query->orderBy($this->orderField, $this->orderDirection);
            })
            ->when($this->etablissementId, function ($query) {
                $query->where('demandes.etablissement_id', $this->etablissementId);
            })
            ->select('demandes.*', 'etablissements.nom as nom_etablissement', 'type_demandes.libelle as type_demande_libelle', 'etat_workflows.libelle as etat_libelle')
            ->paginate(20),
            "typeDemandes" => TypeDemande::all(),
        ]);



    }
}
