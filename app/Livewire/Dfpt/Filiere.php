<?php

namespace App\Livewire\Dfpt;

use App\Models\Classe;
use Livewire\Component;
use Livewire\WithPagination;

class Filiere extends Component
{
    use WithPagination;
    public $search;
    public $selectedSecteur;
    public $count;
    public function resetAll(){
        $this->selectedSecteur ="";
        $this->search = "";
        $this->resetPage();

    }
    public function render()
    {
        $data =  Classe::query('classes')
                    ->join('niveau_etudes as niveaux','niveaux.id', '=', 'classes.niveau_etude_id')
                    ->join('metiers','metiers.id','=','niveaux.metier_id')
                    ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                    ->leftJoin('secteurs','secteurs.id','=','filieres.secteur_id')
                    // Classes ayant au moins un inscrit, toutes années confondues : même critère
                    // que l'indicateur « Filières » du tableau de bord (DashboardStats::filieresFixesCount()).
                    // EXISTS plutôt qu'une jointure : une ligne par classe, pas une par inscrit.
                    ->join('etablissements', 'etablissements.id', '=', 'classes.etablissement_id')
                    ->whereExists(fn ($q) => $q->selectRaw('1')->from('inscriptions')
                        ->join('apprenants', 'apprenants.id', '=', 'inscriptions.apprenant_id')
                        ->whereColumn('inscriptions.classe_id', 'classes.id')
                        ->where('apprenants.isDeleted', 0));

        // Tous les secteurs proposés dans le filtre, quel que soit celui déjà choisi.
        $secteurs = (clone $data)->toBase()->whereNotNull('secteurs.id')->distinct()
            ->orderBy('secteurs.libelle')->get(['secteurs.id', 'secteurs.libelle']);

        $data->when($this->selectedSecteur, fn ($q) => $q->where('secteurs.id', $this->selectedSecteur));

        // Nombre de filières (et non de classes), comme sur le tableau de bord.
        $this->count = (clone $data)->distinct()->count('filieres.id');
        // Une ligne par filière.
        $filieres = (clone $data)->toBase()
            ->groupBy('filieres.id', 'filieres.nom', 'secteurs.libelle')
            ->select('filieres.id', 'filieres.nom as filiereName', 'secteurs.libelle as secteurName')
            ->orderBy('filieres.nom')
            ->paginate(10);

        return view('livewire.dfpt.filiere',compact('filieres','secteurs'));
    }
}
