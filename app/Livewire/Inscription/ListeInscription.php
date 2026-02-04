<?php

namespace App\Livewire\Inscription;

use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\AnneeAcademique;
use App\Models\Etablissement;
use App\Models\Devoir;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
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
 public $annee_academique_id;
    
    // ✅ Composition (on garde, mais sans Devoir)
    public $showCompositionModal = false;
    public $compositionMatiereId = null;
    public $compositionSemestre = null;
    public $compositionApprenants = [];
    public $compositionMcc = [];       // ici = note_cc existante, plus de devoir
    public $compositionNotes = [];
    public $compositionMatiereNom = '';
    public $compositionLocked = false;
 public $showAbsenceClasseModal = false;
public $apprenantsAbsModal = [];



#[On('open-absence-classe')]
public function openAbsenceClasseModal()
{
    if (!$this->classe || !$this->annee_academique_id) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    $this->apprenantsAbsModal = Inscription::with('apprenant')
        ->where('classe_id', $this->classe)
        ->where('annee_academique_id', $this->annee_academique_id)
        ->orderBy('id')
        ->get(); 

    $this->showAbsenceClasseModal = true;
}

public function closeAbsenceClasseModal()
{
    $this->showAbsenceClasseModal = false;
}

    public function mount()
    {
        
        $user = auth()->user();
         session()->put('anneeAcademique', $this->anneeAcademique);
    $this->annee_academique_id = $this->anneeAcademique; 
        $etabId = $user?->personnel?->etablissement_id;

        if ($user->hasRole('superadmin')) {
            $this->classes = Classe::where('modalite', 'PPO')->get();
        }
        elseif ($user->hasRole('formateur') && $user->personnel) {
            $this->classes = Classe::where('modalite', 'PPO')
                ->whereHas('formateurs', function ($q) use ($user) {
                    $q->where('personnel_etablissement_id', $user->personnel->id);
                })
                ->get();
        }
        else {
            $etabId = $etabId ?? Etablissement::where('email', $user->email)->value('id');

            $this->classes = $etabId
                ? Classe::where('modalite', 'PPO')->where('etablissement_id', $etabId)->get()
                : collect();
        }

        $this->anneeAcademiques = AnneeAcademique::all();

        $this->selectedsemestre = session()->get('selectedsemestre', '');
        $this->classe = session()->get('currentClasse', '');
        $this->anneeAcademique = session()->get('anneeAcademique', '');

        $this->currentClasse = $this->classe ? Classe::with('formateurs')->find($this->classe) : null;
        $this->selectedApprenant = session()->get('selectedApprenant');
        $this->currentApprenant = null;

        $this->chargerMatieresPourClasse();

        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
        ]);

        $this->loadApprenants();
    }

    private function chargerMatieresPourClasse()
    {
        if (!$this->currentClasse) {
            $this->matieres = [];
            return;
        }

        $user = auth()->user();

        // ✅ coef vient bien de matieres.coef
        if ($user->hasRole('formateur')) {
            $this->matieres = DB::table('classe_formateur_matiere')
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
    }

    public function updatedClasse()
    {
        session()->forget('selectedApprenant');
        session()->put('currentClasse', $this->classe);

        $this->currentClasse = Classe::with('formateurs')->find($this->classe);
        $this->chargerMatieresPourClasse();
        $this->loadApprenants();
    }

    public function updatedAnneeAcademique()
    {
        session()->put('anneeAcademique', $this->anneeAcademique);
    
    $this->annee_academique_id = $this->anneeAcademique; // ✅ sync
        $this->loadApprenants();
    }

    // ✅ IMPORTANT : le hook doit correspondre au nom de la propriété (selectedsemestre)
    public function updatedSelectedsemestre($value)
    {
        Session::put('selectedsemestre', $value);

        if ($this->showCompositionModal && $this->compositionMatiereId) {
            $this->openCompositionClasseModal((int) $this->compositionMatiereId);
        }
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

 
    public function openCompositionClasseModal(int $matiereId)
{
    if (!$this->selectedsemestre) {
        session()->flash('error', 'Veuillez choisir un semestre (1 ou 2) avant d’évaluer.');
        return;
    }

    if (!$this->classe || !$this->anneeAcademique) {
        session()->flash('error', 'Veuillez choisir une classe et une année académique.');
        return;
    }

    $this->compositionMatiereId = $matiereId;
    $this->compositionSemestre  = (int) $this->selectedsemestre;

    // Nom matière
    $m = Matiere::find($matiereId);
    $this->compositionMatiereNom = $m?->nom ?? '';

    // ✅ Charger inscriptions + apprenants (tri par nom/prenom via join)
    $inscriptions = Inscription::query()
        ->join('apprenants as a', 'a.id', '=', 'inscriptions.apprenant_id')
        ->where('inscriptions.classe_id', $this->classe)
        ->where('inscriptions.annee_academique_id', $this->anneeAcademique)
        ->orderByRaw('LOWER(a.nom) ASC')
        ->orderByRaw('LOWER(a.prenom) ASC')
        ->select('inscriptions.*')
        ->with('apprenant')
        ->get();

    $this->compositionApprenants = $inscriptions;

    $ids = $inscriptions->pluck('id')->all();

    // ✅ 1) MCC depuis les devoirs (selon classe + matière + semestre)
    $mccDevoirs = Devoir::query()
        ->where('classe_id', (int) $this->classe)
        ->where('matiere_id', (int) $this->compositionMatiereId)
        ->where('semestre', (int) $this->compositionSemestre)
        ->whereIn('inscription_id', $ids)
        ->whereNotNull('note')
        ->selectRaw('inscription_id, ROUND(AVG(note), 2) as mcc')
        ->groupBy('inscription_id')
        ->pluck('mcc', 'inscription_id')
        ->toArray();

    // ✅ 2) Si Evaluation.note_cc existe déjà, elle prend le dessus
    $mccEval = Evaluation::query()
        ->whereIn('inscription_id', $ids)
        ->where('matiere_id', (int) $this->compositionMatiereId)
        ->where('semestre', (int) $this->compositionSemestre)
        ->whereNotNull('note_cc')
        ->pluck('note_cc', 'inscription_id')
        ->toArray();

    // ✅ Résultat final (on garde TON nom de variable)
    $this->compositionMcc = $mccEval + $mccDevoirs;

    // ✅ Notes composition déjà saisies (si existantes)
    $this->compositionNotes = Evaluation::query()
        ->whereIn('inscription_id', $ids)
        ->where('matiere_id', (int) $this->compositionMatiereId)
        ->where('semestre', (int) $this->compositionSemestre)
        ->pluck('note_composition', 'inscription_id')
        ->toArray();

    // ✅ Verrouillage si au moins une composition existe déjà
    $this->compositionLocked = Evaluation::query()
        ->whereIn('inscription_id', $ids)
        ->where('matiere_id', (int) $this->compositionMatiereId)
        ->where('semestre', (int) $this->compositionSemestre)
        ->whereNotNull('note_composition')
        ->exists();

    if ($this->compositionLocked) {
        session()->flash(
            'error',
            'Composition déjà enregistrée pour cette classe, cette matière et ce semestre. Modification bloquée.'
        );
    }

    $this->showCompositionModal = true;
}


    public function closeCompositionClasseModal()
    {
        $this->showCompositionModal = false;
    }

    public function saveCompositionClasse()
    {
        if (!$this->compositionMatiereId || !$this->compositionSemestre) {
            session()->flash('error', 'Matière/Semestre manquant.');
            return;
        }

        if (!$this->classe || !$this->anneeAcademique) {
            session()->flash('error', 'Classe/Année académique manquante.');
            return;
        }

        $this->validate([
            'compositionNotes'   => 'array',
            'compositionNotes.*' => 'nullable|numeric|min:0|max:20',
        ]);

        $ids = collect($this->compositionApprenants)->pluck('id')->all();
        $matiereId = (int) $this->compositionMatiereId;
        $semestre  = (int) $this->compositionSemestre;

        $exists = Evaluation::query()
            ->whereIn('inscription_id', $ids)
            ->where('matiere_id', $matiereId)
            ->where('semestre', $semestre)
            ->whereNotNull('note_composition')
            ->exists();

        if ($exists) {
            session()->flash('error', 'Composition déjà enregistrée pour ce semestre. Modification bloquée.');
            $this->compositionLocked = true;
            return;
        }

        DB::transaction(function () use ($ids, $matiereId, $semestre) {
            $rows = [];

            foreach ($this->compositionApprenants as $ins) {
                $inscriptionId = (int) $ins->id;
                $noteComp = $this->compositionNotes[$inscriptionId] ?? null;

                if ($noteComp === '' || $noteComp === null) continue;

                $rows[] = [
                    'inscription_id'   => $inscriptionId,
                    'matiere_id'       => $matiereId,
                    'semestre'         => $semestre,
                    'note_cc'          => $this->compositionMcc[$inscriptionId] ?? null, // ✅ note_cc existante
                    'note_composition' => (float) $noteComp,
                ];
            }

            Evaluation::upsert(
                $rows,
                ['inscription_id','matiere_id','semestre'],
                ['note_cc','note_composition']
            );
        });

        session()->flash('success', 'Notes de composition enregistrées avec succès.');
        $this->showCompositionModal = true;
    }

    public function render()
    {
        // ✅ Toujours disponible pour afficher toute la classe
        $matieres = $this->matieres;

        // ✅ Index évaluations pour TOUS les apprenants (classe/année + semestre choisi)
        $evaluIndex = collect();

        if ($this->classe && $this->anneeAcademique && count($this->apprenants)) {
            $ids = collect($this->apprenants)->pluck('id')->all();

            $q = Evaluation::query()->whereIn('inscription_id', $ids);

            if ($this->selectedsemestre) {
                $q->where('semestre', (int) $this->selectedsemestre);
            }

            $all = $q->get();

            // evaluIndex[inscription_id][matiere_id] = Evaluation
            $evaluIndex = $all
                ->groupBy('inscription_id')
                ->map(fn($g) => $g->keyBy('matiere_id'));
        }

        // ✅ Détail apprenant sélectionné (ta logique)
        $inscriptionId = null;
        $evalu = null;

        if ($this->selectedApprenant) {
            $inscription = Inscription::with('anneeAcademique')->find($this->selectedApprenant);
            if ($inscription) {
                $this->currentApprenant = $inscription;
                $inscriptionId = $inscription->id;

                $qry = Evaluation::where('inscription_id', $inscriptionId);
                if ($this->semestreFilter) $qry->where('semestre', $this->semestreFilter);

                $evalu = $qry->get();
                foreach ($evalu as $evaluation) {
                    $evaluation->moyenne = $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition);
                }
            }
        }

        // absences inchangé chez toi
        if ($this->selectedApprenant) {
            $absences = \App\Models\Absence::where('inscription_id', $this->selectedApprenant)
                
                ->get();
        } else {
            $absences = collect();
        }

        return view('livewire.inscription.liste-inscription', [
            'apprenants' => $this->apprenants,
            'inscriptionId' => $inscriptionId,
            'matieres' => $matieres,
            'evalu' => $evalu,
            'currentApprenant' => $this->currentApprenant,
            'anneeAcademiques' => $this->anneeAcademiques,
            'anneeAcademiqueLabel' => $this->anneeAcademiqueLabel,
            'classes' => $this->classes,
            'absences' => $absences,
            'evaluIndex' => $evaluIndex, // ✅ nouveau
             'anneeAcademiques'     => $this->anneeAcademiques,
            'annee_academique_id'  => $this->annee_academique_id,
        ]);
    }
}
