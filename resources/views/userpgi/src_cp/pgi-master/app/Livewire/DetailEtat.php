<?php

namespace App\Livewire;

use App\Models\EtatWorkflow;
use Livewire\Component;

class DetailEtat extends Component
{

    public bool $modifyingEtatSuivant = false;
    public bool $modifyingEtatRejet = false;
    public EtatWorkflow $etatWorkflow;
    public $bouton_suivant;
    public $bouton_rejet;
    public $etat_suivant_id = null;
    public $etat_rejet_id = null;
    public $etatSuivant;
    public $etatRejet;
    public $allEtatWorkflow;

    public function mount()
    {
        $this->bouton_suivant = $this->etatWorkflow->bouton_suivant;
        $this->bouton_rejet = $this->etatWorkflow->bouton_rejet;

        $this->etatSuivant = $this->etatWorkflow->etatSuivant;
        // $this->etatRejet = $this->etatWorkflow->etatRejet;
        $this->etatRejet = $this->etatWorkflow->etatRejet ?? null;

        $this->etat_suivant_id = $this->etatWorkflow->etatSuivant ? $this->etatWorkflow->etatSuivant->id : null;
        $this->etat_rejet_id = $this->etatWorkflow->etatRejet ? $this->etatWorkflow->etatRejet->id : null;

        $this->allEtatWorkflow = EtatWorkflow::where('workflow_id', $this->etatWorkflow->workflow->id)
                                                ->where('id', '!=', $this->etatWorkflow->id)
                                                ->get();


    }



    public function setEtatSuivant(){
        $this->etatWorkflow->bouton_suivant = $this->bouton_suivant;
        $this->etatWorkflow->etat_suivant_id = $this->etat_suivant_id;
        $this->etatWorkflow->save();
        $this->setModifyingBoutonSuivant();

    }

    public function setEtatRejet(){
        $this->etatWorkflow->bouton_rejet = $this->bouton_rejet;
        $this->etatWorkflow->etat_rejet_id = $this->etat_rejet_id;
        $this->etatWorkflow->save();
        $this->setModifyingBoutonRejet();

    }

    public function setModifyingBoutonRejet(){
        $this->modifyingEtatRejet = !$this->modifyingEtatRejet;

    }


    public function setModifyingBoutonSuivant(){
        $this->modifyingEtatSuivant = !$this->modifyingEtatSuivant;

    }

    public function toggleEstRejetable()
    {
        $this->etatWorkflow->est_rejetable = !$this->etatWorkflow->est_rejetable;
        $this->etatWorkflow->save();
    }


    public function render()
    {
        return view('livewire.detail-etat');
    }
}
