<?php

namespace App\Livewire\DFPT;

use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Region;
use Illuminate\Support\Arr;
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
    public $communes;
    public $etablissements;
    public $niveaux;
    public $classes;
    public $count;
    public $selectedNiveau;
    public $selectedFiliere;
    public $filieres;
    public $regions;
    public $departements;
    public $selectedRegion;
    public $selectedDepartemant;

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
    }

    public function data() {
        $this->regions = Region::query()->get();

        $data = Apprenant::query('apprenants')
            ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
            ->join('classes','classes.id','=','inscriptions.classe_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
            ->join('etablissements','etablissements.id','=','classes.etablissement_id');

        $this->niveaux = $data->select('niveaux.*')->get()->unique('id');
        $this->classes = $data->select('classes.*')->get()->unique('id');
        $apprenants = $data->select('apprenants.*')->get();

        $idCommunesInApprenant = data_get($apprenants->toArray(),'*.commune_id');
        $this->communes = Commune::query()->whereIn('id', $idCommunesInApprenant)->get();
        $this->etablissements = Etablissement::query()->where('is_active', 1)->get();
    }

    public function render()
    {
        $this->data();

        $apprenantsAll = Apprenant::query('apprenants')
            ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
            ->join('classes','classes.id','=','inscriptions.classe_id')
            ->join('etablissements','etablissements.id','=','classes.etablissement_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
            ->select('apprenants.*','niveaux.nom as niveauName','classes.libelle as classeName','etablissements.sigle as etablissementSigle')
            ->where(function($query) {
                $query->where('apprenants.sexe','like', '%'. $this->selectedsexe.'%');

                if ($this->selectedCommune) {
                    $query->where('apprenants.commune_id', $this->selectedCommune);
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

                if ($this->selectedEtablissement) {
                    $query->where('etablissements.id', $this->selectedEtablissement);
                }

                if ($this->selectedRegion) {
                    $this->departements = Departement::query()->where('region_id', $this->selectedRegion)->get();
                    $communes = Commune::query()->whereIn('departement_id', Arr::pluck($this->departements, 'id'))->get();
                    $query->whereIn('apprenants.commune_id', Arr::pluck($communes, 'id'));
                }

                if ($this->selectedDepartemant) {
                    $communes = Commune::query()->where('departement_id', $this->selectedDepartemant)->get();
                    $query->whereIn('apprenants.commune_id', Arr::pluck($communes, 'id'));
                }

                $query->where('apprenants.isDeleted', 0);
            });

        if ($this->selectedRegion || $this->selectedDepartemant) {
            if ($this->selectedRegion) {
                $this->departements = Departement::query()->where('region_id', $this->selectedRegion)->get();
                $communes = Commune::query()->whereIn('departement_id', Arr::pluck($this->departements, 'id'))->get();
            }

            if ($this->selectedDepartemant) {
                $communes = Commune::query()->where('departement_id', $this->selectedDepartemant)->get();
            }
        } else {
            $this->departements = Departement::query()->get();
        }

       // Clone la requête pour avoir un count cohérent
       $countQuery = clone $apprenantsAll;
       $countQuery->select('apprenants.id'); // Important : ne pas laisser le select initial
       $this->count = $countQuery->count();

$apprenants = $apprenantsAll->paginate(50);

        $this->filieres = $apprenantsAll->select('filieres.*')->get()->unique('id');

        return view('livewire.dfpt.getallapprenant', compact('apprenants'));
    }
}
