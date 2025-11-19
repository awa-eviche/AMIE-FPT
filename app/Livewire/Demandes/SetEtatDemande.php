<?php

namespace App\Livewire\Demandes;

use App\Models\EtatWorkflow;
use App\Services\WorkflowTools;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SetEtatDemande extends Component
{
    public $demande;
    public EtatWorkflow $etat;
    private WorkflowTools $workflowTools;
    public bool $refused = false;
    public $motifRejet = null;

    public $disabled = false;

    public function boot(WorkflowTools $workflowTools){
        $this->workflowTools = $workflowTools;
    }



    public function mount(){
        // il faut vérifier les condition est-ce qu'il est autorisé à faire l'action
        // if(!$this->workflowTools->checkAccessRights($this->demande, Auth::user())){
        //     return redirect()->route('demande.index', $this->demande->id);
        // }
        $this->etat = $this->demande->etat;

    }

    public function toggleRefusing(){
        $this->refused = !$this->refused;
    }

    public function next(){

        if ($this->disabled) {
            return;
        }

        $this->disabled = true;

        if(!$this->workflowTools->checkAccessRights($this->demande, Auth::user())){
            return redirect()->route('demande.show', $this->demande->id);
        }
        $this->workflowTools->next($this->demande, Auth::user()->id);
        return redirect()->route('demande.show', $this->demande->id);
    }

    public function rejet(){
        if ($this->disabled) {
            return;
        }

        $this->disabled = false;

        if(!$this->workflowTools->checkAccessRights($this->demande, Auth::user())){
            return redirect()->route('demande.show', $this->demande->id);
        }
        $this->workflowTools->reject($this->demande, Auth::user()->id, $this->motifRejet);
        return redirect()->route('demande.show', $this->demande->id);
    }

    public function decision(){
        $this->toggleRefusing();
        // $this->rejet();
        // return redirect()->route('demande.indexRejet', $this->demande->id);
    }


    public function render()
    {
        return view('livewire.demandes.set-etat-demande');
    }
}
