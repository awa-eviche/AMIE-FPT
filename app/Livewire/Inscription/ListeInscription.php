<?php

namespace App\Livewire\Inscription;

use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\AnneeAcademique;
use App\Models\Etablissement;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ListeInscription extends Component
{
    public $search = "";
    public $startLimit;
    public $count;
    public $evaluationId;
    public $classe;
    public $currentClasse;
    public $classes = [];
    public $apprenants = [];
    public $selectedApprenant;
    public $currentApprenant;
    public $evaluations;
    public $matieres;
    public $inscription;
    public $selectedsemestre;
    public $semestreFilter;
    public $estEnCreationEvaluation = false;
    public $showModal = false;
    public $anneeAcademique;
    public $anneeAcademiques;
    public $anneeAcademiqueLabel;

    public $showDevoirsModal = false;
public $devoirsMatiereId;
public $devoirsInscriptionId;
public $devoirsSemestre;

protected $listeners = ['moyenneCCUpdated' => 'refreshMoyenneCC'];

public $moyenneCC = [];

    public function mount()
    {
        $user = auth()->user();
        $etabId = $user?->personnel?->etablissement_id;

        /**
         * 🎯 Filtrage des classes selon le rôle utilisateur
         */
        if ($user->hasRole('superadmin')) {
            // 👑 Superadmin → toutes les classes PPO
            $this->classes = Classe::where('modalite', 'PPO')->get();
        } 
        elseif ($user->hasRole('formateur') && $user->personnel) {
            // 👨‍🏫 Formateur → uniquement les classes qui lui sont assignées via formateur_etablissement
            $this->classes = Classe::where('modalite', 'PPO')
                ->whereHas('formateurs', function ($q) use ($user) {
                    $q->where('personnel_etablissement_id', $user->personnel->id);
                })
                ->get();
        } 
        else {
            // 👷 Chef de travaux / Chef d’établissement → classes de leur établissement
            $etabId = $etabId ?? Etablissement::where('email', $user->email)->value('id');

            $this->classes = $etabId
                ? Classe::where('modalite', 'PPO')
                    ->where('etablissement_id', $etabId)
                    ->get()
                : collect();
        }

        // 🔸 Années académiques
        $this->anneeAcademiques = AnneeAcademique::all();

        // 🔸 Sessions et initialisation
        $this->selectedsemestre = session()->get('selectedsemestre', '');
        $this->classe = session()->get('currentClasse', '');
        $this->anneeAcademique = session()->get('anneeAcademique', '');

        $this->currentClasse = $this->classe ? Classe::with('formateurs')->find($this->classe) : null;
        $this->selectedApprenant = session()->get('selectedApprenant');
        $this->currentApprenant = null;

        if ($this->currentClasse) {
            $user = auth()->user();
            if ($user->hasRole('formateur')) {
                $this->matieres = \Illuminate\Support\Facades\DB::table('classe_formateur_matiere')
                    ->join('matieres', 'classe_formateur_matiere.matiere_id', '=', 'matieres.id')
                    ->where('classe_formateur_matiere.classe_id', $this->currentClasse->id)
                    ->where('classe_formateur_matiere.formateur_id', $user->id)
                    ->select('matieres.id', 'matieres.nom', 'matieres.coef')
                    ->get();
            } else {
                $this->matieres = Matiere::where('niveau_etude_id', $this->currentClasse->niveau_etude->id)
                    ->select('id', 'nom', 'coef')
                    ->get();
            }
        } else {
            $this->matieres = [];
        }
        

        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
        ]);

        $this->loadApprenants();
    }

    public function updatedClasse()
    {
        session()->forget('selectedApprenant');
        session()->put('currentClasse', $this->classe);

        $this->currentClasse = Classe::with('formateurs')->find($this->classe);
        if ($this->currentClasse) {
            $user = auth()->user();
            if ($user->hasRole('formateur')) {
                $this->matieres = \Illuminate\Support\Facades\DB::table('classe_formateur_matiere')
                    ->join('matieres', 'classe_formateur_matiere.matiere_id', '=', 'matieres.id')
                    ->where('classe_formateur_matiere.classe_id', $this->currentClasse->id)
                    ->where('classe_formateur_matiere.formateur_id', $user->id)
                    ->select('matieres.id', 'matieres.nom', 'matieres.coef')
                    ->get();
            } else {
                $this->matieres = Matiere::where('niveau_etude_id', $this->currentClasse->niveau_etude->id)
                    ->select('id', 'nom', 'coef')
                    ->get();
            }
        } else {
            $this->matieres = [];
        }
        

        $this->loadApprenants();
    }

    public function updatedAnneeAcademique()
    {
        session()->put('anneeAcademique', $this->anneeAcademique);
        $this->loadApprenants();
    }

    public function updatedSelectedSemestre($value)
    {
        Session::put('selectedsemestre', $value);
    }

    public function loadApprenants()
    {
        if ($this->classe && $this->anneeAcademique) {
            $this->apprenants = Inscription::with(['apprenant.user', 'anneeAcademique'])
                ->where('classe_id', $this->classe)
                ->where('annee_academique_id', $this->anneeAcademique)
                ->get();

            $this->anneeAcademiqueLabel = $this->anneeAcademiques
                ->firstWhere('id', $this->anneeAcademique)?->code;
        } else {
            $this->apprenants = [];
            $this->anneeAcademiqueLabel = null;
        }
    }

    public function loadCompetences($id)
    {
        $this->selectedApprenant = $id;
        session()->put('selectedApprenant', $id);
        return redirect()->route('inscription.index');
    }

    public function calculerMoyenne($note_cc, $note_composition)
    {
        return ($note_cc !== null && $note_composition !== null)
            ? ($note_cc + $note_composition) / 2
            : null;
    }

    public function openDevoirsModal($matiereId, $inscriptionId, $semestre = null)
    {
        
        $this->devoirsSemestre = $semestre ?? $this->selectedsemestre ?? 1;
    
        $this->devoirsMatiereId = $matiereId;
        $this->devoirsInscriptionId = $inscriptionId;
    
        $this->showDevoirsModal = true;
    }
    
    public function closeDevoirsModal()
    {
        $this->showDevoirsModal = false;
    }
 public function refreshMoyenneCC($payload)
{
    $evaluation = Evaluation::where([
        'inscription_id' => $payload['inscriptionId'],
        'matiere_id' => $payload['matiereId'],
        'semestre' => $payload['semestre'],
    ])->first();

    $this->moyenneCC[$payload['matiereId']] = $evaluation?->note_cc ?? null;
}

    public function render()
    {
        $inscriptionId = null;
        $evaluationId = null;
        $matieres = null;
        $evalu = null;

        if ($this->selectedApprenant) {
            $inscription = Inscription::with('anneeAcademique')->find($this->selectedApprenant);

            if ($inscription) {
                $this->currentApprenant = $inscription;
                $inscriptionId = $inscription->id;

                $qry = Evaluation::where('inscription_id', $inscriptionId);
                if ($this->semestreFilter) {
                    $qry->where('semestre', $this->semestreFilter);
                }

                $evalu = $qry->get();
                $user = auth()->user();
                $classeId = optional($inscription->classe)->id;
                
                if ($user->hasRole('formateur')) {
                   
                    $matieres = \Illuminate\Support\Facades\DB::table('classe_formateur_matiere')
                        ->join('matieres', 'classe_formateur_matiere.matiere_id', '=', 'matieres.id')
                        ->where('classe_formateur_matiere.classe_id', $classeId)
                        ->where('classe_formateur_matiere.formateur_id', $user->id)
                        ->select('matieres.id', 'matieres.nom', 'matieres.coef')
                        ->get();
                } else {
                    $matieres = Matiere::where('niveau_etude_id', optional($inscription->classe)->niveau_etude->id)
                        ->select('id', 'nom', 'coef')
                        ->get();
                }
                
                foreach ($evalu as $evaluation) {
                    $evaluation->moyenne = $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition);
                }
            }
        }
if ($this->selectedApprenant) {
    $inscription = \App\Models\Inscription::find($this->selectedApprenant);
    $absences = \App\Models\Absence::where('inscription_id', $this->selectedApprenant)
        ->orderBy('date_absence', 'desc')
        ->get();
} else {
    $absences = collect();
}

        return view('livewire.inscription.liste-inscription', [
            'apprenants' => $this->apprenants,
            'inscriptionId' => $inscriptionId,
            'evaluationId' => $evaluationId,
            'matieres' => $matieres,
            'evalu' => $evalu,
            'currentApprenant' => $this->currentApprenant,
            'anneeAcademiques' => $this->anneeAcademiques,
            'anneeAcademiqueLabel' => $this->anneeAcademiqueLabel,
            'classes' => $this->classes,
		'absences' => $absences,
        ]);
    }
}