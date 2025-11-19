<?php

namespace App\Livewire\Ia;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GetAllEtablissement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $count;
    public $search = '';
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedClasse;
    public $selectedRegion;
    public $selectedDepartemant;
    public $regions;
    public $departements;
    public $communes;
    public $filieres;
    public $selectedFiliere;
    public $selectedNiveau;
    public $niveaux;
    public $classes;

    // Reset filtres
    public function resetAll()
    {
        $this->selectedsexe = "";
        $this->search = "";
        $this->selectedEtablissement = "";
        $this->selectedDepartemant = "";
        $this->selectedRegion = "";
        $this->selectedClasse = "";
        $this->selectedCommune = "";
        $this->selectedNiveau = "";
        $this->selectedFiliere = "";
        $this->resetPage();
    }

    /*** IMPORTANT: reset pagination quand un filtre change ***/
    public function updatingSearch()            { $this->resetPage(); }
    public function updatingSelectedCommune()   { $this->resetPage(); }
    public function updatingSelectedDepartemant(){ $this->resetPage(); }
    public function updatingSelectedRegion()    { $this->resetPage(); }
    public function updatingSelectedNiveau()    { $this->resetPage(); }
    public function updatingSelectedClasse()    { $this->resetPage(); }
    public function updatingSelectedFiliere()   { $this->resetPage(); }

    public function render()
    {
        if (Auth::user()->inspecteur()->first() === null) {
            return view('livewire.ia.get-all-etablissement', ['etablissements' => null]);
        }

        // Départements de l’IA de l’inspecteur
        $this->departements = Auth::user()->inspecteur->ia?->departements()->get() ?? collect();

        // Communes accessibles par défaut (périmètre IA)
        $communesIAIds = Commune::query()
            ->whereIn('departement_id', Arr::pluck($this->departements, 'id'))
            ->pluck('id')
            ->toArray();

        // Base query (sans colonnes spécifiques)
        $base = Etablissement::query()
            ->join('communes', 'communes.id', '=', 'etablissements.commune_id')
            ->join('classes', 'classes.etablissement_id', '=', 'etablissements.id')
            ->join('niveau_etudes', 'niveau_etudes.id', '=', 'classes.niveau_etude_id')
            ->join('metiers', 'metiers.id', '=', 'niveau_etudes.metier_id')
            ->join('filieres', 'filieres.id', '=', 'metiers.filiere_id')
            ->where('etablissements.is_active', 1);

        // Recherche texte
        if ($this->search !== '') {
            $base->where(function ($q) {
                $q->where('etablissements.nom', 'like', '%' . $this->search . '%')
                  ->orWhere('etablissements.email', 'like', '%' . $this->search . '%')
                  ->orWhere('etablissements.reference', 'like', '%' . $this->search . '%')
                  ->orWhere('communes.libelle', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre périmètre géographique
        if ($this->selectedCommune) {
            $base->where('etablissements.commune_id', $this->selectedCommune);
        } elseif ($this->selectedDepartemant) {
            $communesDept = Commune::where('departement_id', $this->selectedDepartemant)->pluck('id');
            $base->whereIn('etablissements.commune_id', $communesDept);
            // mettre à jour la liste des communes du sélecteur
            $this->communes = Commune::where('departement_id', $this->selectedDepartemant)->get();
        } elseif ($this->selectedRegion) {
            // restreindre aux départements de cette région mais toujours dans le périmètre IA
            $deptRegion = Departement::where('region_id', $this->selectedRegion)->pluck('id');
            $communesRegionDansIA = Commune::whereIn('departement_id', $deptRegion)
                ->whereIn('departement_id', Arr::pluck($this->departements, 'id'))
                ->pluck('id');
            $base->whereIn('etablissements.commune_id', $communesRegionDansIA);
            // optionnel: $this->departements = Departement::whereIn('id', $deptRegion)->get();
        } else {
            // Périmètre IA par défaut
            $base->whereIn('etablissements.commune_id', $communesIAIds);
            // liste des communes par défaut pour le select
            $this->communes = Commune::whereIn('id', $communesIAIds)->get();
        }

        // Filtres académiques
        if ($this->selectedNiveau)  { $base->where('niveau_etudes.id', $this->selectedNiveau); }
        if ($this->selectedClasse)  { $base->where('classes.id', $this->selectedClasse); }
        if ($this->selectedFiliere) { $base->where('filieres.id', $this->selectedFiliere); }

        /*** CLONES pour éviter les effets de bord ***/
        $qCount   = (clone $base);
        $qNiveaux = (clone $base);
        $qClasses = (clone $base);
        $qFilieres= (clone $base);
        $qData    = (clone $base);

        // Compte distinct
        $this->count = $qCount->distinct('etablissements.id')->count('etablissements.id');

        // Valeurs disponibles pour les filtres (dépendent du périmètre + recherche + filtres déjà posés)
        $this->niveaux  = $qNiveaux ->select('niveau_etudes.id', 'niveau_etudes.nom')->distinct()->orderBy('niveau_etudes.nom')->get();
        $this->classes  = $qClasses ->select('classes.id', 'classes.libelle')->distinct()->orderBy('classes.libelle')->get();
        $this->filieres = $qFilieres->select('filieres.id', 'filieres.nom')->distinct()->orderBy('filieres.nom')->get();

        // Données paginées
        $etablissements = $qData
            ->select('etablissements.*', 'communes.libelle as nameCommune')
            ->groupBy('etablissements.id')
            ->paginate(10);

        return view('livewire.ia.get-all-etablissement', compact('etablissements'));
    }
}
