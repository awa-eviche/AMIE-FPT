<?php

namespace App\Livewire\Dfpt;

use App\Models\Classe;
use Livewire\Component;
use Livewire\WithPagination;

class Filiere extends Component
{
    use WithPagination;
    public $search;
    public $selectedNiveau;
    public $selectedClasse;
    public $selectedSecteur;
    public $count;
    public function resetAll(){
        $this->selectedNiveau;
        $this->selectedSecteur ="";
        $this->search = "";
        $this->selectedClasse =  "";

    }
    public function render()
    {
        $data =  Classe::query('classes')
                    ->join('inscriptions','inscriptions.classe_id', '=', 'classes.id')
                    ->join('niveau_etudes as niveaux','niveaux.id', '=', 'classes.niveau_etude_id')
                    ->join('metiers','metiers.id','=','niveaux.metier_id')
                    ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                    ->join('secteurs','secteurs.id','=','filieres.secteur_id')
                    ->Where(function($query) {
                        if ($this->selectedNiveau) {
                            $query->Where('niveaux.id',$this->selectedNiveau);
                        }
                        if ($this->selectedClasse) {
                            $query->Where('classes.id',$this->selectedClasse);
                        }
                        if ($this->selectedSecteur) {
                            $query->Where('secteurs.id',$this->selectedSecteur);
                        }
                                                                    
                    });
        $this->count = $data->distinct(['classes.id'])->count();
        $niveaux = $data->select('niveaux.*')->get()->unique('id');
        $classes = $data->select('classes.*')->get();
        $secteurs = $data->select('secteurs.*')->get();
        $filieres = $data->select('classes.*','filieres.nom as filiereName','secteurs.libelle as secteurName','metiers.*','niveaux.nom as niveauName')->distinct(['classes.id'])->paginate(10);
        
        return view('livewire.dfpt.filiere',compact('filieres','niveaux','classes','secteurs'));
    }
}
