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
        $data = ModelsMetier::query()
                    ->leftJoin('filieres','filieres.id', '=', 'metiers.filiere_id')
                    ->leftJoin('secteurs','secteurs.id','=','filieres.secteur_id')
                    ->when($this->selectedSecteur, fn ($q) => $q->where('secteurs.id', $this->selectedSecteur))
                    // Métiers ayant au moins un inscrit, toutes années confondues : même critère
                    // que l'indicateur « Métiers » du tableau de bord (DashboardStats::metiersCount()).
                    ->whereExists(fn ($sub) => $sub->selectRaw('1')
                        ->from('niveau_etudes')
                        ->join('classes', 'classes.niveau_etude_id', '=', 'niveau_etudes.id')
                        ->join('etablissements', 'etablissements.id', '=', 'classes.etablissement_id')
                        ->join('inscriptions', 'inscriptions.classe_id', '=', 'classes.id')
                        ->join('apprenants', 'apprenants.id', '=', 'inscriptions.apprenant_id')
                        ->whereColumn('niveau_etudes.metier_id', 'metiers.id')
                        ->where('apprenants.isDeleted', 0));
        $this->count = (clone $data)->distinct()->count('metiers.id');
        $secteurs = Secteur::query()->get();
        $metiers = $data->select('filieres.nom as filiereName','secteurs.libelle as secteurName','metiers.*')->orderBy('metiers.nom')->paginate(10);


        return view('livewire.dfpt.metier',compact('secteurs','metiers'));
    }
}
