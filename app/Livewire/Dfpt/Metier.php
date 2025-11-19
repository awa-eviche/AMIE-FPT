<?php

namespace App\Livewire\Dfpt;

use App\Models\Metier as ModelsMetier;
use App\Models\Secteur;
use Livewire\Component;
use Livewire\WithPagination;

class Metier extends Component
{
    use WithPagination;
    public $search;
    public $selectedFiliere;
    public $selectedSecteur;

    public $count;
    public function resetAll(){
        $this->selectedSecteur ="";
        $this->search = "";

    }
    public function render()
    {
        $data = ModelsMetier::query('metiers')
                    ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                    ->join('secteurs','secteurs.id','=','filieres.secteur_id')
                    ->Where(function($query) {
                        if ($this->selectedSecteur) {
                            $query->Where('secteurs.id',$this->selectedSecteur)
                                    ->join('filieres', 'filieres.secteur_id', '=','secteurs.id');
                        }

                    });
        $this->count = $data->select('filieres.nom as filiereName','secteurs.libelle as secteurName','metiers.*')->distinct(['filieres.id'])->count();
        $secteurs = Secteur::query()->get();
        $metiers = $data->select('filieres.nom as filiereName','secteurs.libelle as secteurName','metiers.*')->distinct(['filieres.id'])->paginate(10);


        return view('livewire.dfpt.metier',compact('secteurs','metiers'));
    }
}
