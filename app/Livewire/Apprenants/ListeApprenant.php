<?php

namespace App\Livewire\Apprenants;

use App\Models\Apprenant;
use Livewire\Component;
use Livewire\WithPagination;

class ListeApprenant extends Component
{
    use WithPagination;
    public $search = "";
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
        $this->startLimit += 10;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {
    }

    public function render()
    {
        $apprenants = [];
        $count = 0;

        if (auth()->user()->can('visualiser_apprenant') && auth()->user()->hasRole(config('constants.roles.chef_etablissement'))) {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id;
                $qry = Apprenant::where('isDeleted', false)
                    ->where('etablissement_id', $idEtablissement)
                    ->where(function ($query) {
                        $query->where("nomTuteur", "like", "%{$this->search}%")
                            ->orWhere('prenomTuteur', 'like', "%{$this->search}%")
                            ->orWhere('prenomTuteur', 'like', "%{$this->search}%")
                            ->orWhere('numTelTuteur', 'like', "%{$this->search}%")
                            ->orWhere('situationMatrimoniale', 'like', "%{$this->search}%")
                            ->orWhere('prenomPere', 'like', "%{$this->search}%")
                            ->orWhere('nomPere', 'like', "%{$this->search}%")
                            ->orWhere('prenomPere', 'like', "%{$this->search}%")
                            ->orWhere('nomMere', 'like', "%{$this->search}%")
                            ->orWhere('prenomMere', 'like', "%{$this->search}%")
                            ->orWhere('nom', 'like', "%{$this->search}%")
                            ->orWhere('prenom', 'like', "%{$this->search}%")
                            ->orWhere('telephone', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    });


                $count = $qry->count();

                $this->count = $count;
                if ($count == 0) $this->startLimit = 0;

                $apprenants = $qry->orderBy('id', 'desc')->offset($this->startLimit)->limit(10)->get();
            }
        }
        return view('livewire.apprenant.liste-apprenant', [
            "apprenants" => $apprenants,
            "count" => $count
        ]);
    }
}
