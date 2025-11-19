<?php

namespace App\Livewire\Classe;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\NiveauEtudeEtablissement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ListeClasse extends Component
{
    use WithPagination;

    public $search = "";
    public $startLimit;
    public $count;

    public $selectedFiliere;
    public $selectedMetier;
    public $selectedAnnee;

    public $selectedClasseFiliere;
    public $selectedClasseMetier;
    public $selectedClasseAnnee;

    public $selectedEtablissement;

    public $metiers = [];
    public $filieres = [];

    // 🔸 Ajout : persistance via query string (utile si on partage l’URL)
    protected $queryString = [
        'selectedEtablissement' => ['except' => ''],
        'selectedClasseFiliere' => ['except' => ''],
        'selectedClasseMetier' => ['except' => ''],
        'selectedClasseAnnee' => ['except' => ''],
    ];

    public function mount()
    {
        $this->search = '';
        $this->startLimit = 0;
        $this->count = 0;

        $user = Auth::user();

        // 🔹 Restauration des filtres depuis la session
        $this->selectedEtablissement = session('selectedEtablissement', $this->selectedEtablissement);
        $this->selectedClasseFiliere = session('selectedClasseFiliere', $this->selectedClasseFiliere);
        $this->selectedClasseMetier = session('selectedClasseMetier', $this->selectedClasseMetier);
        $this->selectedClasseAnnee = session('selectedClasseAnnee', $this->selectedClasseAnnee);

        // 🔸 Si l'utilisateur est rattaché à un établissement
        if ($user->personnel && $user->personnel->etablissement_id) {
            $etablissementId = $user->personnel->etablissement_id;
            $this->selectedEtablissement = $etablissementId;

            $niveauIds = NiveauEtudeEtablissement::where('etablissement_id', $etablissementId)
                ->pluck('niveau_etude_id');

            $this->metiers = Metier::whereHas('niveaux', function ($query) use ($niveauIds) {
                $query->whereIn('id', $niveauIds);
            })->get();

            $metierIds = NiveauEtude::whereIn('id', $niveauIds)->pluck('metier_id');
            $this->filieres = Filiere::whereHas('metiers', function ($query) use ($metierIds) {
                $query->whereIn('id', $metierIds);
            })->get();
        } else {
            $this->metiers = Metier::all();
            $this->filieres = Filiere::all();
        }
    }

    public function updated($property)
    {
        if (in_array($property, [
            'selectedFiliere', 'selectedMetier',
            'selectedClasseFiliere', 'selectedClasseMetier',
            'selectedEtablissement', 'selectedClasseAnnee'
        ])) {
            $this->startLimit = 0;
            $this->persistFilters();
        }
    }

    // 🔹 Sauvegarde automatique dans la session
    private function persistFilters()
    {
        session([
            'selectedEtablissement' => $this->selectedEtablissement,
            'selectedClasseFiliere' => $this->selectedClasseFiliere,
            'selectedClasseMetier' => $this->selectedClasseMetier,
            'selectedClasseAnnee' => $this->selectedClasseAnnee,
        ]);
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function next()
    {
        $this->startLimit += 10;
    }

    public function prev()
    {
        $this->startLimit -= 10;
    }

    public function render()
    {
        $user = Auth::user();
        $qry = Classe::query();

        // 🔹 Filtrage selon le rôle utilisateur
        if ($user->hasRole('formateur') && $user->personnel) {
            $qry->whereHas('formateurs', function ($query) use ($user) {
                $query->where('personnel_etablissement_id', $user->personnel->id);
            });
        } elseif ($user->can('visualiser_mes_filieres') || $user->can('edit_mes_filieres')) {
            if ($user->personnel && $user->personnel->etablissement_id) {
                $qry->where('etablissement_id', $user->personnel->etablissement_id);
            }
        }

        // 🔹 Filtres appliqués
        if ($this->search) {
            $qry->where('libelle', 'like', "%{$this->search}%");
        }

        if ($this->selectedClasseFiliere) {
            $qry->whereHas('niveau_etude.metier', function ($query) {
                $query->where('filiere_id', $this->selectedClasseFiliere);
            });
        }

        if ($this->selectedClasseMetier) {
            $qry->whereHas('niveau_etude', function ($query) {
                $query->where('metier_id', $this->selectedClasseMetier);
            });
        }

        if ($this->selectedEtablissement) {
            $qry->where('etablissement_id', $this->selectedEtablissement);
        }

        if ($this->selectedClasseAnnee) {
            $qry->whereHas('annee_academique', function ($query) {
                $query->where('id', $this->selectedClasseAnnee);
            });
        }

        $count = $qry->count();
        $this->count = $count;

        if ($count == 0) {
            $this->startLimit = 0;
        }

        $classes = $qry->with(['etablissement', 'niveau_etude.metier.filiere'])
            ->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();

        $annee_academique = AnneeAcademique::all();
        $etablissements = Etablissement::orderBy('nom', 'asc')->get();

        return view('livewire.classe.liste-classe', [
            'classes' => $classes,
            'metiers' => $this->metiers,
            'filieres' => $this->filieres,
            'annee_academique' => $annee_academique,
            'etablissements' => $etablissements,
            'count' => $count,
        ]);
    }
}
