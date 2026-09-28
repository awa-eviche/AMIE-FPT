<?php

namespace App\Livewire\DFPT;

use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Region;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Getallapprenant extends Component
{
    use WithPagination;

    // ✅ Durées de cache : les listes de filtres (régions, niveaux,
    // classes...) changent rarement -> cache long et global (partagé par
    // tous les admins). Le total/la page dépendent des filtres choisis par
    // chaque utilisateur -> cache court, par combinaison de filtres.
    private const DROPDOWN_CACHE_TTL = 600; // 10 min
    private const RESULT_CACHE_TTL   = 120; // 2 min

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
        // ✅ Ces listes sont identiques pour tout le monde (pas propres à
        // l'utilisateur) et ne changent que quand un niveau/une classe/une
        // filière est ajouté(e) : on les met en cache 10 min au lieu de
        // relancer 4 requêtes à 5 jointures à chaque ouverture de la modale.
        $this->regions = Cache::remember('dfpt.apprenants.regions', self::DROPDOWN_CACHE_TTL,
            fn () => Region::all()
        );

        $this->etablissements = Cache::remember('dfpt.apprenants.etablissements', self::DROPDOWN_CACHE_TTL,
            fn () => Etablissement::where('is_active', 1)->get()
        );

        $filtres = Cache::remember('dfpt.apprenants.filtres', self::DROPDOWN_CACHE_TTL, function () {
            $chain = Apprenant::query()
                ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
                ->join('classes','classes.id','=','inscriptions.classe_id')
                ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
                ->join('metiers','metiers.id','=','niveaux.metier_id')
                ->join('filieres','filieres.id','=','metiers.filiere_id');

            // ✅ DISTINCT côté SQL au lieu de récupérer toutes les lignes
            // (avec doublons, un par inscription) puis dédupliquer en PHP.
            $niveaux  = (clone $chain)->select('niveaux.*')->distinct()->get();
            $classes  = (clone $chain)->select('classes.*')->distinct()->get();
            $filieres = (clone $chain)->select('filieres.*')->distinct()->get();

            // ✅ On ne récupère qu'une seule colonne (pas apprenants.* pour
            // des milliers de lignes) pour construire la liste des communes.
            $communeIds = (clone $chain)->pluck('apprenants.commune_id')->filter()->unique();
            $communes = Commune::whereIn('id', $communeIds)->get();

            $annees = DB::table('annee_academiques')
                ->join('inscriptions', 'annee_academiques.id', '=', 'inscriptions.annee_academique_id')
                ->join('classes', 'classes.id', '=', 'inscriptions.classe_id')
                ->select('annee_academiques.id', 'annee_academiques.code')
                ->distinct()
                ->get();

            return compact('niveaux', 'classes', 'filieres', 'communes', 'annees');
        });

        $this->niveaux   = $filtres['niveaux'];
        $this->classes   = $filtres['classes'];
        $this->filieres  = $filtres['filieres'];
        $this->communes  = $filtres['communes'];
        $this->annees    = $filtres['annees'];
    }

    /**
     * Clé de cache dérivée des filtres actuellement sélectionnés : deux
     * utilisateurs (ou deux ouvertures) avec les mêmes filtres partagent le
     * même résultat en cache.
     */
    private function filtersCacheKey(): string
    {
        return 'dfpt.apprenants.result.' . md5(serialize([
            $this->selectedsexe,
            $this->selectedEtablissement,
            $this->selectedCommune,
            $this->selectedClasse,
            $this->selectedNiveau,
            $this->selectedFiliere,
            $this->selectedRegion,
            $this->selectedDepartemant,
            $this->selectedAnnee,
            $this->getPage(),
        ]));
    }

    /**
     * Base de la requête "apprenants filtrés" (jointures + filtres), sans
     * SELECT ni pagination : réutilisée à la fois pour l'agrégat par année
     * et pour la page de résultats affichée.
     */
    private function filteredApprenantsQuery()
    {
        return Apprenant::query()
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
            ->when($this->selectedClasse, fn($q) => $q->where('classes.id', $this->selectedClasse));
    }

    public function render()
    {
        $this->data();

        // ✅ Résultat (total + page) mis en cache par combinaison de filtres :
        // rouvrir la modale avec les mêmes filtres (le cas le plus fréquent :
        // aucun filtre) ne relance pas la requête à 7 jointures sur ~10 000
        // apprenants. Un ajout/suppression d'apprenant peut mettre jusqu'à
        // 2 min à se refléter ici — acceptable pour un compteur de dashboard.
        $result = Cache::remember($this->filtersCacheKey(), self::RESULT_CACHE_TTL, function () {
            // ✅ Simple COUNT (pas de récupération des lignes) : $apprenantsParAnnee
            // n'était utilisé nulle part dans la vue — sa suppression fait gagner
            // ~3s à elle seule, en plus d'éviter de charger ~10 000 lignes
            // complètes en PHP à chaque ouverture de la modale.
            $count = $this->filteredApprenantsQuery()->count();

            // ✅ Requête séparée, paginée à 50 lignes (au lieu de réexécuter la
            // même requête complète une 3e fois).
            $apprenants = $this->filteredApprenantsQuery()
                ->select(
                    'apprenants.*',
                    'niveaux.nom as niveauName',
                    'classes.libelle as classeName',
                    'etablissements.sigle as etablissementSigle',
                    'annee_academiques.code as anneeCode'
                )
                ->paginate(50);

            return ['count' => $count, 'apprenants' => $apprenants];
        });

        $this->count = $result['count'];

        return view('livewire.dfpt.getallapprenant', [
            'apprenants' => $result['apprenants'],
            'apprenantsParAnnee' => $this->apprenantsParAnnee
        ]);
    }
}
