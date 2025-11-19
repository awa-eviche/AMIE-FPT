<?php

namespace App\Livewire\Demandes;

use Livewire\Component;

class RecapDemande extends Component
{

    public $donnees;
    public $typeDemande;
    public bool $is_charging = true;

    public function mount(){
        $this->is_charging = false;
    }


    public function soumettre(){
        $this->emetteur(2);

    }

    public function back(){
        $this->emetteur(1);
    }

    public function enregistrerBrouillon(){
        $this->emetteur(0);

    }


    /**
     * permet d'emettre l'évenement et un nombre qui sera utiliser pour savoir ce qu'il faudra faire
     * si le nombre emis est 0, on saura que l'utilisateur a fait un entregistrer en brouillon
     * si le nombre emis est 1, on saura que l'utilisateur a fait un back
     * si le nombre emis est 2, l'utilisateur a soumis sa demande
     */
    public function emetteur($nombre){
        $this->is_charging = true;
        $this->dispatch("recapLeft", $nombre);

    }

    public function render()
    {
        return view('livewire.demandes.recap-demande');
    }
}
