<?php

namespace App\Livewire\DFPT;

use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Region;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Getallapprenant extends Component
{
    use WithPagination;

    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedClasse;
    public $selectedNiveau;
    public $selectedFiliere;
    public $selectedRegion;
    public $selectedDepartemant;
    public $selectedAnnee = '';

    public $communes = [];
    public $departements = [];
    public $etablissements = [];
    public $niveaux = [];
    public $classes = [];
    public $filieres = [];
    public $regions = [];
    public $annees = [];
    public $count;
    public $apprenantsParAnnee = [];

    public function setSearch() {}

    public function resetAll() {
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
        $this->resetPage();
    }

    // Charger les données pour les filtres
    public function data() {
        $this->regions = Region::all();
        $this->etablissements = Etablissement::where('is_active', 1)->get();

        $data = Apprenant::query()
            ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
            ->join('classes','classes.id','=','inscriptions.classe_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id','=','metiers.filiere_id')
            ->join('etablissements','etablissements.id','=','classes.etablissement_id');

        $this->niveaux = $data->select('niveaux.*')->get()->unique('id');
        $this->classes = $data->select('classes.*')->get()->unique('id');
        $apprenants = $data->select('apprenants.*')->get();

        $idCommunesInApprenant = data_get($apprenants->toArray(),'*.commune_id');
        $this->communes = Commune::whereIn('id', $idCommunesInApprenant)->get();

        $this->filieres = $data->select('filieres.*')->get()->unique('id');

        // Charger toutes les années académiques
        $this->annees = DB::table('annee_academiques')
            ->join('inscriptions', 'annee_academiques.id', '=', 'inscriptions.annee_academique_id')
            ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
            ->select('annee_academiques.id', 'annee_academiques.code')
            ->distinct()
            ->get();
    }

    public function render()
    {
        $this->data();

        // Requête principale avec tous les filtres
        $apprenantsQuery = Apprenant::query()
            ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
            ->join('classes','classes.id','=','inscriptions.classe_id')
            ->join('etablissements','etablissements.id','=','classes.etablissement_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id','=','metiers.filiere_id')
            ->join('annee_academiques','annee_academiques.id','=','inscriptions.annee_academique_id')
            ->where('apprenants.isDeleted', 0)
            ->when($this->selectedsexe, fn($q) => $q->where('apprenants.sexe', $this->selectedsexe))
            ->when($this->selectedFiliere, fn($q) => $q->where('filieres.id', $this->selectedFiliere))
            ->when($this->selectedEtablissement, fn($q) => $q->where('etablissements.id', $this->selectedEtablissement))
            ->when($this->selectedAnnee, fn($q) => $q->where('annee_academiques.id', $this->selectedAnnee))
            ->when($this->selectedRegion, function($q){
                $departements = Departement::where('region_id', $this->selectedRegion)->pluck('id');
                $communes = Commune::whereIn('departement_id', $departements)->pluck('id');
                $q->whereIn('apprenants.commune_id', $communes);
            })
            ->when($this->selectedDepartemant, function($q){
                $communes = Commune::where('departement_id', $this->selectedDepartemant)->pluck('id');
                $q->whereIn('apprenants.commune_id', $communes);
            })
            ->when($this->selectedCommune, fn($q) => $q->where('apprenants.commune_id', $this->selectedCommune))
            ->when($this->selectedNiveau, fn($q) => $q->where('niveaux.id', $this->selectedNiveau))
            ->when($this->selectedClasse, fn($q) => $q->where('classes.id', $this->selectedClasse))
            ->select(
                'apprenants.*',
                'niveaux.nom as niveauName',
                'classes.libelle as classeName',
                'etablissements.sigle as etablissementSigle',
                'annee_academiques.code as anneeCode'
            );

        // Clone pour le count et le regroupement par année
        $cloneQuery = clone $apprenantsQuery;
        $this->count = $cloneQuery->count();

        $this->apprenantsParAnnee = $cloneQuery->get()
            ->groupBy('anneeCode')
            ->map(fn($group, $annee) => [
                'annee' => $annee,
                'total' => $group->count()
            ])
            ->values();

        $apprenants = $apprenantsQuery->paginate(50);

        return view('livewire.dfpt.getallapprenant', [
            'apprenants' => $apprenants,
            'apprenantsParAnnee' => $this->apprenantsParAnnee
        ]);
    }
}
