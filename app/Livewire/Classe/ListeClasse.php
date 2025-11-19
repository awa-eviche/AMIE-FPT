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

    public function mount()
    {
        $this->search = '';
        $this->startLimit = 0;
        $this->count = 0;

        $user = Auth::user();

        // Si l'utilisateur est rattachÃ© Ã  un Ã©tablissement
        if ($user->personnel && $user->personnel->etablissement_id) {
            $etablissementId = $user->personnel->etablissement_id;
            $this->selectedEtablissement = $etablissementId;

            // RÃ©cupÃ¨re les niveaux liÃ©s Ã  lâ€™Ã©tablissement
            $niveauIds = NiveauEtudeEtablissement::where('etablissement_id', $etablissementId)
                ->pluck('niveau_etude_id');

            // MÃ©tiers associÃ©s aux niveaux
            $this->metiers = Metier::whereHas('niveaux', function ($query) use ($niveauIds) {
                $query->whereIn('id', $niveauIds);
            })->get();

            // FiliÃ¨res associÃ©es Ã  ces mÃ©tiers
            $metierIds = NiveauEtude::whereIn('id', $niveauIds)->pluck('metier_id');
            $this->filieres = Filiere::whereHas('metiers', function ($query) use ($metierIds) {
                $query->whereIn('id', $metierIds);
            })->get();
        } else {
            // Utilisateur non rattachÃ© (admin par ex)
            $this->metiers = Metier::all();
            $this->filieres = Filiere::all();
        }
    }
 public function updated($property)
{
    // RafraÃ®chit la pagination Ã  chaque changement de filtre
    if (in_array($property, [
        'selectedFiliere', 'selectedMetier',
        'selectedClasseFiliere', 'selectedClasseMetier',
        'selectedEtablissement', 'selectedClasseAnnee'
    ])) {
        $this->startLimit = 0;
    }
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

        /** -----------------------------------------------------------
         * ðŸ”’ Filtrage selon le rÃ´le de lâ€™utilisateur
         * ----------------------------------------------------------- */
        if ($user->hasRole('formateur') && $user->personnel) {
            // ðŸŽ¯ Si câ€™est un formateur â†’ uniquement les classes qui lui sont assignÃ©es
            $qry->whereHas('formateurs', function ($query) use ($user) {
                $query->where('personnel_etablissement_id', $user->personnel->id);
            });
        } elseif ($user->can('visualiser_mes_filieres') || $user->can('edit_mes_filieres')) {
            // ðŸ‘·â€â™‚ï¸ Chef de travaux / chef dâ€™Ã©tablissement â†’ leurs classes de lâ€™Ã©tablissement
            if ($user->personnel && $user->personnel->etablissement_id) {
                $qry->where('etablissement_id', $user->personnel->etablissement_id);
            }
        } else {
            // ðŸ‘‘ Autres rÃ´les (admin, DAGE, etc.) â†’ accÃ¨s Ã  tout
        }

        /** -----------------------------------------------------------
         * ðŸ”Ž Filtres de recherche et sÃ©lections
         * ----------------------------------------------------------- */
        if (!empty($this->search)) {
            $qry->where('libelle', 'like', "%{$this->search}%");
        }

        if ($this->selectedFiliere) {
            $qry->where('filiere_id', $this->selectedFiliere);
        }

        if ($this->selectedClasseFiliere) {
            $qry->whereHas('niveau_etude.metier', function ($query) {
                $query->where('filiere_id', $this->selectedClasseFiliere);
            });
        }

        if ($this->selectedMetier) {
            $qry->where('metier_id', $this->selectedMetier);
        }

        if ($this->selectedClasseMetier) {
            $qry->whereHas('niveau_etude', function ($query) {
                $query->where('metier_id', $this->selectedClasseMetier);
            });
        }

        if ($this->selectedEtablissement) {
            $qry->where('etablissement_id', $this->selectedEtablissement);
        }

        if ($this->selectedAnnee) {
            $qry->where('annee_academique_id', $this->selectedAnnee);
        }

        if ($this->selectedClasseAnnee) {
            $qry->whereHas('annee_academique', function ($query) {
                $query->where('id', $this->selectedClasseAnnee);
            });
        }

        /** -----------------------------------------------------------
         * ðŸ”¢ Pagination manuelle (offset + limit)
         * ----------------------------------------------------------- */
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

        /** -----------------------------------------------------------
         * ðŸ“˜ DonnÃ©es complÃ©mentaires pour les filtres
         * ----------------------------------------------------------- */
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
