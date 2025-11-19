<?php

namespace App\Livewire\Demandes;

use App\Models\Demande;
use Livewire\Component;

class ListeDemandePromoteur extends Component
{

    public $search;
    public $startLimit;
    public $count;

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

    public function render()
    {
        $qry = Demande::join('entreprises', 'demandes.entreprise_id', '=', 'entreprises.id')
                ->join('type_demandes', 'demandes.type_demande_id', '=', 'type_demandes.id')
                ->join('etat_workflows', 'demandes.etat_id', '=', 'etat_workflows.id')
                ->where(function($query) {
                    $query->where('entreprises.nom_entreprise', 'like', "%{$this->search}%")
                        ->orWhere('demandes.libelle', 'like', "%{$this->search}%")
                        ->orWhere('type_demandes.libelle', 'like', "%{$this->search}%")
                        ->orWhere('etat_workflows.libelle', 'like', "%{$this->search}%");
                })
                ->select('demandes.*', 'entreprises.nom_entreprise as nom_entreprise', 'type_demandes.libelle as type_demande_libelle', 'etat_workflows.libelle as etat_libelle');

        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        // dump($qry);
        // dump($this->startLimit);
        $demandes = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        // dump($demandes);

        return view('livewire.demandes.liste-demande-promoteur',['demandes'=>$demandes,'count'=>$count]);
    }
}
