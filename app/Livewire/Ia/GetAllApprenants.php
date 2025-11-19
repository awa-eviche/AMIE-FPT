<?php

namespace App\Livewire\Ia;

use App\Models\Apprenant;
use App\Models\Commune;
use App\Models\Etablissement;
use App\Models\AnneeAcademique;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GetAllApprenants extends Component
{
    use WithPagination; 

    public $search = '';
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedClasse;
    public $selectedNiveau;
    public $selectedFiliere;
    public $selectedRegion;
    public $selectedDepartemant;
    public $selectedAnnee; // 🔹 Nouveau filtre

    public $communes;
    public $etablissements;
    public $niveaux;
    public $classes;
    public $filieres;
    public $regions;
    public $departements;
    public $annees; // 🔹 Liste des années académiques

    public $count = 0;

    // Réinitialiser tous les filtres
    public function resetAll()
    {
        $this->selectedsexe = "";
        $this->search = "";
        $this->selectedDepartemant = "";
        $this->selectedRegion = "";
        $this->selectedEtablissement = "";
        $this->selectedClasse = "";
        $this->selectedCommune = "";
        $this->selectedNiveau = "";
        $this->selectedFiliere = "";
        $this->selectedAnnee = "";
    }

    public function render()
    {
        if (Auth::user()->inspecteur()->first() !== null) {

            // 🔹 Récupération des départements de l'IA
            $this->departements = Auth::user()->inspecteur()->first()
                ->ia()->first()
                ->departements()->get();

            // 🔹 Communes accessibles
            $this->communes = Commune::whereIn(
                'departement_id',
                Arr::pluck($this->departements, 'id')
            )->get();

            // 🔹 Années académiques disponibles
            $this->annees = AnneeAcademique::orderBy('code', 'desc')->get();

            // 🔹 Base de la requête
            $apprenantsAll = Apprenant::query()
                ->join('inscriptions', 'inscriptions.apprenant_id', '=', 'apprenants.id')
                ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
                ->join('etablissements', 'etablissements.id', '=', 'classes.etablissement_id')
                ->join('niveau_etudes as niveaux', 'niveaux.id', '=', 'classes.niveau_etude_id')
                ->join('metiers', 'metiers.id', '=', 'niveaux.metier_id')
                ->join('filieres', 'filieres.id', '=', 'metiers.filiere_id')
                ->where('apprenants.isDeleted', 0);

            // 🔹 Filtres
            if (!empty($this->selectedsexe)) {
                $apprenantsAll->where('apprenants.sexe', $this->selectedsexe);
            }

            if ($this->selectedCommune) {
                $apprenantsAll->where('apprenants.commune_id', $this->selectedCommune);
            }

            if ($this->selectedEtablissement) {
                $apprenantsAll->where('etablissements.id', $this->selectedEtablissement);
            }

            if ($this->selectedNiveau) {
                $apprenantsAll->where('niveaux.id', $this->selectedNiveau);
            }

            if ($this->selectedClasse) {
                $apprenantsAll->where('classes.id', $this->selectedClasse);
            }

            if ($this->selectedFiliere) {
                $apprenantsAll->where('filieres.id', $this->selectedFiliere);
            }

            if ($this->selectedRegion) {
                $communes = Commune::whereIn('departement_id', Arr::pluck($this->departements, 'id'))->pluck('id');
                $apprenantsAll->whereIn('apprenants.commune_id', $communes);
            }

            if ($this->selectedDepartemant) {
                $communes = Commune::where('departement_id', $this->selectedDepartemant)->pluck('id');
                $apprenantsAll->whereIn('apprenants.commune_id', $communes);
            } else {
                $apprenantsAll->whereIn('apprenants.commune_id', Arr::pluck($this->communes, 'id'));
            }

            // 🔹 Filtre Année académique
            if ($this->selectedAnnee) {
                $apprenantsAll->where('inscriptions.annee_academique_id', $this->selectedAnnee);
            }

            // 🔹 Compteur des apprenants
            $this->count = $apprenantsAll->distinct('apprenants.id')->count('apprenants.id');

            // 🔹 Listes de filtres
            $this->niveaux = $apprenantsAll->select('niveaux.id', 'niveaux.nom')->distinct()->get();
            $this->classes = $apprenantsAll->select('classes.id', 'classes.libelle')->distinct()->get();
            $this->filieres = $apprenantsAll->select('filieres.id', 'filieres.nom')->distinct()->get();
            $this->etablissements = Etablissement::whereIn('commune_id', Arr::pluck($this->communes, 'id'))->get();

            // 🔹 Pagination des apprenants
            $apprenants = $apprenantsAll->select(
                    'apprenants.*',
                    'niveaux.nom as niveauName',
                    'classes.libelle as classeName',
                    'etablissements.sigle as etablissementSigle'
                )
                ->distinct('apprenants.id')
                ->paginate(50);

            return view('livewire.ia.getallapprenants', compact('apprenants'));
        }

        return view('livewire.ia.getallapprenants', ['apprenants' => null]);
    }
}
