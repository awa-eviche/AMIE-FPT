<?php

namespace App\Livewire\Etablissements;

use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\Commune;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

use function Laravel\Prompts\select;

class GetAllApprenant extends Component
{
    use WithPagination;
    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedNiveau;
    public $selectedClasse;
    public $selectedFiliere;
    public $filieres;
    public $count;

    public function setSearch(){
    }

    public function resetAll()
    {
        $this->selectedsexe = "";      // Réinitialiser le sexe
        $this->selectedNiveau = "";    // Réinitialiser le niveau
        $this->search = "";            // Réinitialiser la recherche
        $this->selectedEtablissement = "";
        $this->selectedClasse = "";
        $this->selectedFiliere = "";
    
        // Réinitialiser la page de la pagination
        $this->resetPage();
    }
    
    public function render()
    {
        $etablissementId = auth()->user()->personnel->etablissement_id;
    
        // Création de la requête de base
        $query = Classe::query()
            ->where('classes.etablissement_id', $etablissementId)
            ->join('inscriptions', 'inscriptions.classe_id', '=', 'classes.id')
            ->join('apprenants', 'apprenants.id', '=', 'inscriptions.apprenant_id')
            ->join('niveau_etudes as niveaux', 'niveaux.id', '=', 'classes.niveau_etude_id')
            ->join('metiers', 'metiers.id', '=', 'niveaux.metier_id')
            ->join('filieres', 'filieres.id', '=', 'metiers.filiere_id')
            ->where('apprenants.isDeleted', 0);
    
        // Appliquer les filtres si sélectionnés
        if ($this->selectedsexe) {
            $query->where('apprenants.sexe', 'like', '%' . $this->selectedsexe . '%');
        }
        if ($this->selectedNiveau) {
            $query->where('niveaux.id', $this->selectedNiveau);
        }
        if ($this->selectedClasse) {
            $query->where('classes.id', $this->selectedClasse);
        }
        if ($this->selectedFiliere) {
            $query->where('filieres.id', $this->selectedFiliere);
        }
    
        // Calcul du nombre total d'apprenants correspondant aux filtres
        $this->count = $query->count();
    
        // Récupérer les informations uniques pour les filtres
        $this->filieres = $query->select('filieres.*')->distinct()->get();
        $niveaux = $query->select('niveaux.*')->distinct()->get();
        $classes = $query->select('classes.*')->distinct()->get();
    
        // Appliquer la pagination
        $apprenants = $query->select('apprenants.*', 'niveaux.nom as niveauName', 'classes.libelle as classeName')
            ->distinct('apprenants.id')
            ->paginate(50);
    
        return view('livewire.etablissements.get-all-apprenant', compact('apprenants', 'niveaux', 'classes'));
    }
    

}
