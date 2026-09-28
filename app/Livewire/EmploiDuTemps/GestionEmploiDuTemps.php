<?php

namespace App\Livewire\EmploiDuTemps;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Competence;
use App\Models\CreneauEmploiDuTemps;
use App\Models\EmploiDuTemps;
use App\Models\Etablissement;
use App\Models\Matiere;
use App\Models\PersonnelEtablissement;
use App\Models\Ressource;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GestionEmploiDuTemps extends Component
{
    const ROLES_AUTORISES = ['chef_etablissement', 'chef_de_travaux', 'de', 'surveillant'];

    // Sélection
    public $classeId;
    public $anneeAcademiqueId;
    public $typePlanning = 'hebdomadaire'; // 'hebdomadaire' | 'semestriel'
    public $semaine;
    public $semaineMin = 1;
    public $semaineMax = 52;
    public $semestre = 1;

    // EDT courant
    public $emploiDuTempsId;

    // Formulaire créneau
    public $showModal          = false;
    public $creneauId;
    public $jour               = 'lundi';
    public $heureDebut         = '08:00';
    public $heureFin           = '10:00';
    public $salle              = '';
    public $formateurId;
    public $matiereId;
    public $apcContenu; // APC : "ressource:{id}" (compétence générale) ou "competence:{id}" (compétence particulière)

    protected $rules = [
        'classeId'          => 'required|exists:classes,id',
        'anneeAcademiqueId' => 'required|exists:annee_academiques,id',
        'jour'              => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
        'heureDebut'        => 'required',
        'heureFin'          => 'required',
        'formateurId'       => 'required|exists:personnel_etablissements,id',
    ];

    public function mount(): void
    {
        abort_unless(
            auth()->user()->hasAnyRole(self::ROLES_AUTORISES),
            403,
            'Accès réservé aux responsables de l\'établissement.'
        );

        $this->anneeAcademiqueId = session('annee_academique_id')
            ?? \App\Services\AnneeDesNotes::anneeParDefaut()
            ?? AnneeAcademique::where('is_open', true)->value('id')
            ?? AnneeAcademique::orderByDesc('id')->value('id');
        $this->semaine = now()->isoWeek();
    }

    /* ── Propriétés calculées ───────────────────────────── */

    public function getEtablissementProperty(): ?Etablissement
    {
        return auth()->user()->personnel?->etablissement
            ?? Etablissement::first();
    }

    public function getClassesProperty()
    {
        if (!$this->etablissement) return collect();
        return Classe::where('etablissement_id', $this->etablissement->id)->get();
    }

    public function getClasseCouranteProperty(): ?Classe
    {
        return $this->classeId ? Classe::find($this->classeId) : null;
    }

    public function getFormateursProperty()
    {
        if (!$this->classeId || !$this->classeCourante) return collect();

        $table = $this->classeCourante->modalite === 'APC'
            ? 'classe_formateur_competence'
            : 'classe_formateur_matiere';

        $userIds = DB::table($table)
            ->where('classe_id', $this->classeId)
            ->where('annee_academique_id', $this->anneeAcademiqueId)
            ->pluck('formateur_id')
            ->unique();

        if ($userIds->isEmpty()) return collect();

        return PersonnelEtablissement::whereIn('user_id', $userIds)
            ->with('user')
            ->get();
    }

    public function getContenusProperty()
    {
        if (!$this->classeCourante || !$this->formateurId) {
            return $this->classeCourante?->modalite === 'APC'
                ? ['ressources' => collect(), 'particulieres' => collect()]
                : collect();
        }

        $userId = PersonnelEtablissement::find($this->formateurId)?->user_id;
        if (!$userId) {
            return $this->classeCourante->modalite === 'APC'
                ? ['ressources' => collect(), 'particulieres' => collect()]
                : collect();
        }

        if ($this->classeCourante->modalite === 'APC') {
            $competenceIds = DB::table('classe_formateur_competence')
                ->where('classe_id', $this->classeCourante->id)
                ->where('formateur_id', $userId)
                ->where('annee_academique_id', $this->anneeAcademiqueId)
                ->pluck('competence_id')
                ->unique();

            $competences = Competence::whereIn('id', $competenceIds)->get()->keyBy('id');

            // Un formateur peut avoir plusieurs ressources pour une même compétence
            // (générale ou particulière) : on les propose toutes.
            $ressources = Ressource::whereIn('competence_id', $competenceIds)
                ->where('classe_id', $this->classeCourante->id)
                ->where('formateur_id', $userId)
                ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources'),
                    fn ($q) => $q->where('annee_academique_id', $this->anneeAcademiqueId))
                ->get();

            // Les compétences qui n'ont aucune ressource restent sélectionnables directement.
            $competenceIdsAvecRessource = $ressources->pluck('competence_id')->unique()->all();
            $particulieres = $competences->except($competenceIdsAvecRessource)->values();

            return ['ressources' => $ressources, 'particulieres' => $particulieres];
        }

        $matiereIds = DB::table('classe_formateur_matiere')
            ->where('classe_id', $this->classeCourante->id)
            ->where('formateur_id', $userId)
            ->where('annee_academique_id', $this->anneeAcademiqueId)
            ->pluck('matiere_id');

        return Matiere::whereIn('id', $matiereIds)->get();
    }

    public function getEmploiCourantProperty(): ?EmploiDuTemps
    {
        if (!$this->classeId || !$this->anneeAcademiqueId) return null;

        return $this->requeteEdtCourant()
            ->with([
                'creneaux.formateur.user',
                'creneaux.matiere',
                'creneaux.ressource',
                'creneaux.competence',
                'creneaux.elementCompetence',
            ])->first();
    }

    private function requeteEdtCourant()
    {
        $query = EmploiDuTemps::where('classe_id', $this->classeId)
            ->where('annee_academique_id', $this->anneeAcademiqueId)
            ->where('type_planning', $this->typePlanning);

        if ($this->typePlanning === 'hebdomadaire') {
            $query->where('semaine', $this->semaine)->whereNull('semestre');
        } else {
            $query->where('semestre', $this->semestre)->whereNull('semaine');
        }

        return $query;
    }

    /* ── Actions ────────────────────────────────────────── */

    public function updatedClasseId(): void
    {
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    public function updatedTypePlanning(): void
    {
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    public function updatedSemestre(): void
    {
        $this->semestre = max(1, min(2, (int) $this->semestre));
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    public function updatedSemaine(): void
    {
        $this->semaine = max($this->semaineMin, min($this->semaineMax, (int) $this->semaine));
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    public function updatedSemaineMin(): void
    {
        $this->semaineMin = max(1, (int) $this->semaineMin);
        if ($this->semaine < $this->semaineMin) {
            $this->semaine = $this->semaineMin;
        }
    }

    public function updatedSemaineMax(): void
    {
        $this->semaineMax = min(53, (int) $this->semaineMax);
        if ($this->semaine > $this->semaineMax) {
            $this->semaine = $this->semaineMax;
        }
    }

    public function updatedAnneeAcademiqueId(): void
    {
        session()->put('annee_academique_id', $this->anneeAcademiqueId);
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    public function semainePrecedente(): void
    {
        if ($this->semaine > $this->semaineMin) {
            $this->semaine--;
            $this->emploiDuTempsId = null;
            $this->autoCharger();
        }
    }

    public function semaineSuivante(): void
    {
        if ($this->semaine < $this->semaineMax) {
            $this->semaine++;
            $this->emploiDuTempsId = null;
            $this->autoCharger();
        }
    }

    public function allerSemaineActuelle(): void
    {
        $this->semaine = max($this->semaineMin, min($this->semaineMax, now()->isoWeek()));
        $this->emploiDuTempsId = null;
        $this->autoCharger();
    }

    private function autoCharger(): void
    {
        if (!$this->classeId || !$this->anneeAcademiqueId) return;

        $edt = $this->requeteEdtCourant()->first();

        if (!$edt) {
            $edt = EmploiDuTemps::create([
                'classe_id'           => $this->classeId,
                'etablissement_id'    => $this->etablissement->id,
                'annee_academique_id' => $this->anneeAcademiqueId,
                'type_planning'       => $this->typePlanning,
                'semaine'             => $this->typePlanning === 'hebdomadaire' ? $this->semaine : null,
                'semestre'            => $this->typePlanning === 'semestriel' ? $this->semestre : null,
                'statut'              => 'brouillon',
            ]);
        }

        $this->emploiDuTempsId = $edt->id;
    }

    public function updatedFormateurId(): void
    {
        $this->matiereId = null;
        $this->apcContenu = null;
    }

    public function ouvrirModalCreneau(?int $id = null): void
    {
        abort_unless($this->estAutorise(), 403);
        $this->resetCreneauForm();
        if ($id) {
            $c = CreneauEmploiDuTemps::findOrFail($id);
            $this->creneauId   = $c->id;
            $this->jour        = $c->jour;
            $this->heureDebut  = $c->heure_debut;
            $this->heureFin    = $c->heure_fin;
            $this->salle       = $c->salle;
            $this->formateurId = $c->personnel_etablissement_id;
            $this->matiereId   = $c->matiere_id;

            if ($c->ressource_id) {
                $this->apcContenu = 'ressource:' . $c->ressource_id;
            } elseif ($c->competence_id) {
                $this->apcContenu = 'competence:' . $c->competence_id;
            }
        }
        $this->showModal = true;
    }

    public function sauvegarderCreneau(): void
    {
        abort_unless($this->estAutorise(), 403);

        if (!$this->emploiDuTempsId && $this->emploiCourant) {
            $this->emploiDuTempsId = $this->emploiCourant->id;
        }

        if (!$this->emploiDuTempsId) {
            $this->autoCharger();
        }

        $this->jour      = strtolower(trim((string) $this->jour));
        $this->heureDebut = trim((string) $this->heureDebut);
        $this->heureFin   = trim((string) $this->heureFin);

        $joursValides = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];

        $this->validate([
            'jour'        => 'required|in:' . implode(',', $joursValides),
            'heureDebut'  => 'required',
            'heureFin'    => 'required',
            'formateurId' => 'required|exists:personnel_etablissements,id',
        ], [
            'jour.required'        => 'Le jour est obligatoire.',
            'jour.in'              => 'Le jour sélectionné est invalide.',
            'heureDebut.required'  => 'L\'heure de début est obligatoire.',
            'heureFin.required'    => 'L\'heure de fin est obligatoire.',
            'formateurId.required' => 'Veuillez sélectionner un formateur.',
            'formateurId.exists'   => 'Le formateur sélectionné est invalide.',
        ]);

        $ressourceId  = null;
        $competenceId = null;

        if ($this->classeCourante?->modalite === 'APC' && $this->apcContenu) {
            [$type, $val] = array_pad(explode(':', $this->apcContenu, 2), 2, null);
            if ($type === 'ressource') {
                $ressourceId = (int) $val;
            } elseif ($type === 'competence') {
                $competenceId = (int) $val;
            }
        }

        $data = [
            'emploi_du_temps_id'         => $this->emploiDuTempsId,
            'personnel_etablissement_id' => $this->formateurId,
            'jour'                       => $this->jour,
            'heure_debut'                => $this->heureDebut,
            'heure_fin'                  => $this->heureFin,
            'salle'                      => $this->salle,
            'matiere_id'                 => $this->matiereId ?: null,
            'ressource_id'               => $ressourceId,
            'competence_id'              => $competenceId,
            'element_competence_id'      => null,
        ];

        if ($this->creneauId) {
            CreneauEmploiDuTemps::findOrFail($this->creneauId)->update($data);
        } else {
            CreneauEmploiDuTemps::create($data);
        }

        $this->showModal = false;
        $this->resetCreneauForm();
        session()->flash('success', 'Créneau enregistré.');
    }

    public function supprimerCreneau(int $id): void
    {
        abort_unless($this->estAutorise(), 403);
        CreneauEmploiDuTemps::findOrFail($id)->delete();
        session()->flash('success', 'Créneau supprimé.');
    }

    public function fermerModal(): void
    {
        $this->showModal = false;
        $this->resetCreneauForm();
    }

    public function estAutorise(): bool
    {
        return auth()->user()->hasAnyRole(self::ROLES_AUTORISES);
    }

    private function resetCreneauForm(): void
    {
        $this->creneauId   = null;
        $this->jour        = 'lundi';
        $this->heureDebut  = '08:00';
        $this->heureFin    = '10:00';
        $this->salle       = '';
        $this->formateurId = null;
        $this->matiereId   = null;
        $this->apcContenu  = null;
    }

    public function render()
    {
        return view('livewire.emploi-du-temps.gestion', [
            'annees'         => AnneeAcademique::orderByDesc('id')->get(),
            'classes'        => $this->classes,
            'formateurs'     => $this->formateurs,
            'contenus'       => $this->contenus,
            'emploiCourant'  => $this->emploiCourant,
            'classeCourante' => $this->classeCourante,
            'estAutorise'    => $this->estAutorise(),
        ]);
    }
}
