<?php

namespace App\Livewire\Reinscription;

use Livewire\Component;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ListeAdmis extends Component
{
    public $classe = '';
    public $classes = [];
    public $annees = [];
    public $currentClasse = null;
    public $admis = [];
    // Décision par apprenant : [apprenant_id => 'passe' | 'redouble' | ''] ('' = non réinscrit).
    public $decisions = [];
    public $nouvelle_classe_id = '';
    public $annee_academique_id = '';
    public $annee_reinscription_id = '';
    // Pagination de l'affichage : toute la classe reste chargée, les décisions portent sur toutes les pages.
    public $page = 1;
    public $parPage = 20;

    public function allerPage($page)
    {
        $this->page = max(1, min((int) $page, (int) ceil(count($this->admis) / $this->parPage)));
    }

    public function mount()
    {
        $this->classes = Classe::where('etablissement_id', auth()->user()->etablissementId())->get();
        $this->annees = AnneeAcademique::orderByDesc('code')->get();

        // Par défaut : on réinscrit depuis l'avant-dernière année vers la dernière.
        $this->annee_reinscription_id = $this->annees->get(0)->id ?? '';
        $this->annee_academique_id = $this->annees->get(1)->id ?? '';
    }

    public function updatedClasse()
    {
        $this->page = 1;
        $this->loadAdmis();
    }

    public function updatedAnneeAcademiqueId()
    {
        $this->page = 1;
        if ($this->classe) {
            $this->loadAdmis();
        }
    }

    private function loadAdmis()
    {
        $this->currentClasse = Classe::with('niveau_etude')->find($this->classe);
        $this->admis = [];
        $this->decisions = [];

        if (!$this->currentClasse || !$this->annee_academique_id) return;

        // Charger les inscriptions dans cette classe ET pour l'année sélectionnée
        $inscriptions = Inscription::with('apprenant')
            ->where('classe_id', $this->currentClasse->id)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->get();

        // Inscriptions déjà prises sur une année postérieure : l'apprenant est déjà réinscrit
        // (dans la même classe s'il redouble, dans une autre s'il passe).
        $annee = AnneeAcademique::find($this->annee_academique_id);
        $suites = Inscription::with('classe', 'anneeAcademique')
            ->whereIn('apprenant_id', $inscriptions->pluck('apprenant_id'))
            ->whereIn('annee_academique_id', AnneeAcademique::where('code', '>', $annee->code)->pluck('id'))
            ->get()
            ->keyBy('apprenant_id');

        // Classes APC : pas de notion de moyenne.
        $isApc = $this->currentClasse->modalite === 'APC';
        // Mêmes matières que le bulletin : celles du niveau affectées à la classe pour l'année.
        $classeId = (int) $this->currentClasse->id;
        $anneeId = $this->annee_academique_id;
        $matieres = $isApc
            ? collect()
            : Matiere::where('niveau_etude_id', $this->currentClasse->niveau_etude_id)
                ->whereIn('id', function ($query) use ($classeId, $anneeId) {
                    $query->select('matiere_id')
                        ->from('classe_formateur_matiere')
                        ->where('classe_id', $classeId)
                        ->where('annee_academique_id', $anneeId)
                        ->whereNotNull('formateur_id');
                })
                ->get();

        $evaluations = $isApc
            ? collect()
            : Evaluation::whereIn('inscription_id', $inscriptions->pluck('id'))
                ->get()
                ->groupBy(['inscription_id', 'semestre']);

        foreach ($inscriptions as $inscription) {
            $moyenne = $isApc ? null : $this->calculerMoyenneAnnuelle($evaluations->get($inscription->id), $matieres);
            $suite = $suites->get($inscription->apprenant_id);

            $this->admis[] = [
                'inscription' => $inscription,
                'moyenne' => $moyenne !== null ? round($moyenne, 2) : null,
                'admis' => $moyenne !== null && $moyenne >= 10,
                'suite' => $suite ? [
                    'id' => $suite->id,
                    'annee' => $suite->anneeAcademique->code ?? '',
                    'classe' => $suite->classe->libelle ?? '',
                    'redoublant' => (bool) $suite->redoublant,
                ] : null,
            ];
            $this->decisions[$inscription->apprenant_id] = '';
        }

        $this->proposerSelonMoyenne();
    }

    /**
     * Pré-remplit les décisions des classes PPO d'après la moyenne : les admis passent,
     * les non-admis redoublent. Les apprenants non évalués et les classes APC restent sans décision.
     */
    public function proposerSelonMoyenne()
    {
        foreach ($this->admis as $entry) {
            $id = data_get($entry, 'inscription.apprenant_id');
            $this->decisions[$id] = '';

            if ($entry['suite'] || $entry['moyenne'] === null) {
                continue;
            }
            $this->decisions[$id] = $entry['admis'] ? 'passe' : 'redouble';
        }
    }

    /**
     * Bascule la décision d'un apprenant : un second clic sur la même décision l'efface.
     */
    public function decider($apprenantId, $decision)
    {
        if (!in_array($decision, ['passe', 'redouble'], true)) return;

        $entry = collect($this->admis)->first(fn($e) => data_get($e, 'inscription.apprenant_id') == $apprenantId);
        if (!$entry || $entry['suite']) return;

        $isApc = $this->currentClasse && $this->currentClasse->modalite === 'APC';
        if ($decision === 'passe' && !$isApc && !$entry['admis']) return;

        $this->decisions[$apprenantId] = ($this->decisions[$apprenantId] ?? '') === $decision ? '' : $decision;
    }

    /**
     * Annule une réinscription faite par erreur (redoublant inscrit à tort, ou passage à tort) :
     * supprime l'inscription de l'année suivante, l'apprenant redevient à réinscrire.
     * Refusé dès que cette inscription porte des données (notes, devoirs, absences, droits...).
     */
    public function annulerReinscription($apprenantId)
    {
        $entry = collect($this->admis)->first(fn($e) => data_get($e, 'inscription.apprenant_id') == $apprenantId);
        if (!$entry || empty($entry['suite']['id'])) return;

        $suite = Inscription::where('id', $entry['suite']['id'])->where('apprenant_id', $apprenantId)->first();

        if ($suite) {
            $nom = trim(data_get($entry, 'inscription.apprenant.prenom') . ' ' . data_get($entry, 'inscription.apprenant.nom'));

            // Toutes les tables rattachées à une inscription (notes, devoirs, absences, droits).
            $liees = [];
            foreach (DB::select("SELECT table_name AS t FROM information_schema.columns
                    WHERE table_schema = DATABASE() AND column_name = 'inscription_id' AND table_name <> 'users'") as $table) {
                if (DB::table($table->t)->where('inscription_id', $suite->id)->exists()) {
                    $liees[] = [
                        'absences' => 'absences', 'devoirs' => 'devoirs', 'devoirapc' => 'devoirs',
                        'evaluations' => 'notes', 'evalutes' => 'notes', 'sommations' => 'notes',
                        'droit_inscription' => "droits d'inscription",
                    ][$table->t] ?? $table->t;
                }
            }

            if ($liees) {
                session()->flash('warning', "Impossible d'annuler la réinscription de $nom : des données sont déjà enregistrées "
                    . "sur sa nouvelle inscription (" . implode(', ', array_unique($liees)) . "). Supprimez-les d'abord.");
                return;
            }

            // Le compte utilisateur de l'apprenant revient sur son inscription d'origine.
            User::where('inscription_id', $suite->id)->update(['inscription_id' => data_get($entry, 'inscription.id')]);
            $suite->delete();
            session()->flash('success', "Réinscription de $nom annulée : vous pouvez maintenant choisir « Passe » ou « Redouble ».");
        }

        // Recharge la liste en conservant les décisions déjà cochées pour les autres apprenants.
        $decisions = $this->decisions;
        $this->loadAdmis();
        foreach ($this->admis as $e) {
            $id = data_get($e, 'inscription.apprenant_id');
            if (!$e['suite'] && $id != $apprenantId && array_key_exists($id, $decisions)) {
                $this->decisions[$id] = $decisions[$id];
            }
        }
        $this->decisions[$apprenantId] = '';
    }

    /**
     * Applique la même décision à tous les apprenants encore à réinscrire.
     * En PPO, seuls les admis peuvent passer : les autres gardent leur décision.
     */
    public function toutMarquer($decision)
    {
        if (!in_array($decision, ['passe', 'redouble', ''], true)) return;

        $isApc = $this->currentClasse && $this->currentClasse->modalite === 'APC';

        foreach ($this->admis as $entry) {
            if ($entry['suite']) continue;
            if ($decision === 'passe' && !$isApc && !$entry['admis']) continue;

            $this->decisions[data_get($entry, 'inscription.apprenant_id')] = $decision;
        }
    }


    public function reinscrire()
    {
        $this->validate([
            'annee_reinscription_id' => 'required|exists:annee_academiques,id',
        ]);

        // Seuls les apprenants de la liste qui ne sont pas déjà réinscrits sont pris en compte.
        $aTraiter = collect($this->admis)->whereNull('suite')->pluck('inscription.apprenant_id');
        $redoublants = $aTraiter->filter(fn($id) => ($this->decisions[$id] ?? '') === 'redouble')->values()->all();
        $autres = $aTraiter->filter(fn($id) => ($this->decisions[$id] ?? '') === 'passe')->values()->all();

        if (!count($redoublants) && !count($autres)) {
            $this->addError('decisions', "Indiquez pour au moins un apprenant s'il passe ou s'il redouble.");
            return;
        }

        if (count($autres)) {
            $this->validate(
                ['nouvelle_classe_id' => 'required|exists:classes,id'],
                ['nouvelle_classe_id.required' => "Choisissez la classe d'accueil des apprenants qui passent."]
            );
        }

        // L'inscription de l'année d'origine est toujours conservée (l'apprenant reste visible dans sa
        // classe pour cette année) : la réinscription crée une nouvelle inscription sur une année postérieure.
        $origine = AnneeAcademique::find($this->annee_academique_id);
        $cible = AnneeAcademique::find($this->annee_reinscription_id);

        if (!$origine || $cible->code <= $origine->code) {
            $this->addError('annee_reinscription_id', "L'année de réinscription doit être postérieure à l'année d'origine.");
            return;
        }

        $ignorés = [];
        $nonAdmis = [];
        $traités = 0;
        $nbRedoublants = 0;

        // Redoublement : nouvelle inscription, marquée redoublant, dans la même classe.
        foreach ($redoublants as $apprenant_id) {
            if (!$this->creerInscription($apprenant_id, $this->currentClasse->id, true)) {
                $ignorés[] = $apprenant_id;
                continue;
            }
            $traités++;
            $nbRedoublants++;
        }

        // Passage dans une autre classe : en PPO il est réservé aux admis, les autres ne peuvent que redoubler.
        $isApc = $this->currentClasse && $this->currentClasse->modalite === 'APC';
        $admis = collect($this->admis)->where('admis', true)->pluck('inscription.apprenant_id')->all();

        foreach ($autres as $apprenant_id) {
            if (!$isApc && !in_array($apprenant_id, $admis)) {
                $nonAdmis[] = $apprenant_id;
                continue;
            }

            if (!$this->creerInscription($apprenant_id, $this->nouvelle_classe_id)) {
                $ignorés[] = $apprenant_id;
                continue;
            }
            $traités++;
        }

        $noms = fn($ids) => \App\Models\Apprenant::whereIn('id', $ids)->get()
            ->map(fn($a) => $a->prenom . ' ' . $a->nom)
            ->implode(', ');

        $avertissements = [];
        if (count($ignorés)) {
            $avertissements[] = "Les apprenants suivants ont déjà une inscription pour cette année : " . $noms($ignorés) . '.';
        }
        if (count($nonAdmis)) {
            $avertissements[] = "Les apprenants suivants ne sont pas admis et ne peuvent être réinscrits que dans la même classe (redoublement) : " . $noms($nonAdmis) . '.';
        }
        if ($avertissements) {
            session()->flash('warning', implode(' ', $avertissements));
        }

        if ($traités > 0) {
            $passages = $traités - $nbRedoublants;
            session()->flash('success', 'Réinscription effectuée avec succès : '
                . "$passages apprenant(s) passent dans la nouvelle classe, $nbRedoublants redoublent.");
        }

        // Les années restent sélectionnées pour enchaîner sur la classe suivante.
        $this->reset(['classe', 'currentClasse', 'admis', 'decisions', 'nouvelle_classe_id', 'page']);
    }


    /**
     * Crée l'inscription de l'année de réinscription, sauf si l'apprenant en a déjà une sur cette année.
     * Le compte utilisateur de l'apprenant suit sa nouvelle inscription.
     */
    private function creerInscription($apprenantId, $classeId, $redoublant = false): bool
    {
        $déjà_inscrit = Inscription::where('apprenant_id', $apprenantId)
            ->where('annee_academique_id', $this->annee_reinscription_id)
            ->exists();

        if ($déjà_inscrit) {
            return false;
        }

        $nouvelle = Inscription::create([
            'apprenant_id' => $apprenantId,
            'classe_id' => $classeId,
            'annee_academique_id' => $this->annee_reinscription_id,
            'redoublant' => $redoublant,
            'dateInscription' => now(),
        ]);

        $origineId = collect($this->admis)->pluck('inscription.id', 'inscription.apprenant_id')->get($apprenantId);
        if ($origineId) {
            User::where('inscription_id', $origineId)->update(['inscription_id' => $nouvelle->id]);
        }

        return true;
    }

    /**
     * Moyenne annuelle calculée comme sur le bulletin : moyenne pondérée de chaque semestre
     * (une matière ne compte que si CC et composition sont notés), puis moyenne des semestres.
     * Seuls les semestres évalués comptent ; null si aucun ne l'est.
     */
    private function calculerMoyenneAnnuelle($evaluationsParSemestre, $matieres)
    {
        $moyennes = [];

        foreach ([1, 2] as $semestre) {
            $evaluations = ($evaluationsParSemestre?->get($semestre) ?? collect())->keyBy('matiere_id');
            $somme = 0;
            $coeffs = 0;

            foreach ($matieres as $matiere) {
                $coef = (float) ($matiere->coef ?? 0);
                $eval = $evaluations->get($matiere->id);

                if ($coef <= 0 || !$eval || $eval->note_cc === null || $eval->note_composition === null) {
                    continue;
                }

                $somme += (((float) $eval->note_cc + (float) $eval->note_composition) / 2) * $coef;
                $coeffs += $coef;
            }

            if ($coeffs > 0) {
                $moyennes[] = round($somme / $coeffs, 2);
            }
        }

        return $moyennes ? array_sum($moyennes) / count($moyennes) : null;
    }

    public function render()
    {
        return view('livewire.reinscription.liste-admis');
    }
}