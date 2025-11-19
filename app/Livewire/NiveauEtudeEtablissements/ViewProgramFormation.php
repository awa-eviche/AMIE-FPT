<?php

namespace App\Livewire\NiveauEtudeEtablissements;

use App\Models\Etablissement;
use App\Models\NiveauEtudeEtablissement;
use App\Services\NotificationService;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Repositories\UserRepository;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ViewProgramFormation extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;
    public $idEtablissement;
    public $etablissement;

    private NotificationService $notificationService;
    private UserRepository $userRepository;

    public function boot(
        NotificationService $notificationService,
        UserRepository $userRepository,
    ) {
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }

    public function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
        ]);
    }

    public function next()
    {
        $this->startLimit += 10;
    }

    public function prev()
    {
        $this->startLimit -= 10;
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {
        // Méthode vide (peut être utilisée plus tard)
    }

    public function render()
    {
        $les_metiers = [];
        $this->etablissement = Etablissement::find($this->idEtablissement);

        // Requête de base
        $qry = NiveauEtudeEtablissement::where('etablissement_id', $this->idEtablissement)
            ->where('isDeleted', false);

        // Recherche par nom de filière
        if ($this->search) {
            $qry->whereHas('filiere', function ($query) {
                $query->where('nom', 'like', "%{$this->search}%");
            });
        }

        $count = $qry->count();

        $niveauetudeetablissements = $qry->orderBy('id', 'desc')->get();

        // Regroupement par métier
        foreach ($niveauetudeetablissements as $niv) {
            $nivE = NiveauEtude::find($niv->niveau_etude_id);

            if ($nivE) {
                // On protège l’accès au métier avec optional()
                $nomMetier = optional(Metier::find($nivE->metier_id))->nom ?? '-';

                if (!isset($les_metiers[$nomMetier])) {
                    $les_metiers[$nomMetier] = [];
                }

                $les_metiers[$nomMetier][] = $nivE;
            }
        }

        return view('livewire.niveauetudeetablissement.view-program-formation', [
            "niveauetudeetablissements" => $niveauetudeetablissements,
            "les_metiers" => $les_metiers,
            "etablissement" => $this->etablissement,
            "count" => $count,
        ]);
    }

    public function checkStatusFormation($id, $idEtablissement)
    {
        $formation = NiveauEtudeEtablissement::where('niveau_etude_id', $id)
            ->where('etablissement_id', $idEtablissement)
            ->first();

        return $formation ? $formation->approved : false;
    }
}
