<?php

namespace App\Livewire\Reinscription;

use Livewire\Component;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\AnneeAcademique;

class ListeAdmis extends Component
{
    public $classe = '';
    public $classes = [];
    public $annees = [];
    public $currentClasse = null;
    public $admis = [];
    public $apprenantsSelectionnes = [];
    public $nouvelle_classe_id = '';
    public $annee_academique_id = '';
    public $annee_reinscription_id = '';

    public function mount()
    {
        $this->classes = Classe::where('etablissement_id', auth()->user()->etablissementId())->get();
        $this->annees = AnneeAcademique::orderByDesc('code')->get();
    }

    public function updatedClasse()
    {
        $this->loadAdmis();
    }

    public function updatedAnneeAcademiqueId()
    {
        if ($this->classe) {
            $this->loadAdmis();
        }
    }

    private function loadAdmis()
    {
        $this->currentClasse = Classe::with('niveau_etude')->find($this->classe);
        $this->admis = [];

        if (!$this->currentClasse || !$this->annee_academique_id) return;

        // Charger les inscriptions dans cette classe ET pour l'année sélectionnée
        $inscriptions = Inscription::with('apprenant')
            ->where('classe_id', $this->currentClasse->id)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->get();

        // Classes APC : pas de notion de moyenne, on liste tous les apprenants de la classe
        // pour permettre leur transfert vers une autre classe.
        if ($this->currentClasse->modalite === 'APC') {
            foreach ($inscriptions as $inscription) {
                $this->admis[] = [
                    'inscription' => $inscription,
                    'moyenne' => null,
                ];
            }
            return;
        }

        $matieres = Matiere::where('niveau_etude_id', $this->currentClasse->niveau_etude_id)->get();

        // Trouver l'année suivante
        $anneeSuivante = AnneeAcademique::where('code', '>', AnneeAcademique::find($this->annee_academique_id)->code)
            ->orderBy('code')
            ->first();
    
        foreach ($inscriptions as $inscription) {
            $apprenantId = $inscription->apprenant_id;
    
            // S’il a déjà une inscription pour l’année SUIVANTE, on l’ignore
            if ($anneeSuivante) {
                $reinscrit = Inscription::where('apprenant_id', $apprenantId)
                    ->where('annee_academique_id', $anneeSuivante->id)
                    ->exists();
    
                if ($reinscrit) {
                    continue; // Déjà réinscrit pour l'année suivante
                }
            }
    
            $moyenne = $this->calculerMoyenneGenerale($inscription, $matieres);
    
            if ($moyenne !== null && $moyenne >= 10) {
                $this->admis[] = [
                    'inscription' => $inscription,
                    'moyenne' => round($moyenne, 2),
                ];
            }
        }
    }
    

    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->apprenantsSelectionnes = collect($this->admis)
                ->pluck('inscription.apprenant.id')
                ->toArray();
        } else {
            $this->apprenantsSelectionnes = [];
        }
    }
    


    public function reinscrire()
    {
        $this->validate([
            'nouvelle_classe_id' => 'required|exists:classes,id',
            'annee_reinscription_id' => 'required|exists:annee_academiques,id',
            'apprenantsSelectionnes' => 'required|array|min:1',
        ]);
    
        $ignorés = [];

        if ($this->currentClasse && $this->currentClasse->modalite === 'APC') {
            // Transfert APC : on déplace l'inscription existante vers la nouvelle classe
            // (et la nouvelle année académique), sans créer de doublon.
            foreach ($this->apprenantsSelectionnes as $apprenant_id) {
                $inscription = Inscription::where('apprenant_id', $apprenant_id)
                    ->where('classe_id', $this->currentClasse->id)
                    ->where('annee_academique_id', $this->annee_academique_id)
                    ->first();

                if (!$inscription) {
                    continue;
                }

                $dejaAilleurs = Inscription::where('apprenant_id', $apprenant_id)
                    ->where('annee_academique_id', $this->annee_reinscription_id)
                    ->where('id', '!=', $inscription->id)
                    ->exists();

                if ($dejaAilleurs) {
                    $ignorés[] = $apprenant_id;
                    continue;
                }

                $inscription->update([
                    'classe_id' => $this->nouvelle_classe_id,
                    'annee_academique_id' => $this->annee_reinscription_id,
                ]);
            }
        } else {
            foreach ($this->apprenantsSelectionnes as $apprenant_id) {
                $déjà_inscrit = Inscription::where('apprenant_id', $apprenant_id)
                    ->where('annee_academique_id', $this->annee_reinscription_id)
                    ->exists();

                if ($déjà_inscrit) {
                    $ignorés[] = $apprenant_id;
                    continue;
                }

                Inscription::create([
                    'apprenant_id' => $apprenant_id,
                    'classe_id' => $this->nouvelle_classe_id,
                    'annee_academique_id' => $this->annee_reinscription_id,
                    'dateInscription' => now(),
                ]);
            }
        }

        if (count($ignorés)) {
            $noms = \App\Models\Apprenant::whereIn('id', $ignorés)->get()
                ->map(fn($a) => $a->prenom . ' ' . $a->nom)
                ->implode(', ');
    
            session()->flash('warning', "Les apprenants suivants ont déjà une inscription pour cette année : $noms");
        }
    
        session()->flash('success', 'Réinscription effectuée avec succès.');
    
        $this->reset([
            'classe', 'currentClasse', 'admis',
            'apprenantsSelectionnes', 'nouvelle_classe_id', 'annee_academique_id', 'annee_reinscription_id'
        ]);
    }
    

    private function calculerMoyenneGenerale($inscription, $matieres)
    {
        $somme = 0;
        $coeffs = 0;

        foreach ($matieres as $matiere) {
            $eval = Evaluation::where('inscription_id', $inscription->id)
                ->where('matiere_id', $matiere->id)
                ->first();

            if ($eval && $matiere->coef > 0) {
                $moy = ($eval->note_cc + $eval->note_composition) / 2;
                $somme += $moy * $matiere->coef;
                $coeffs += $matiere->coef;
            }
        }

        return $coeffs > 0 ? $somme / $coeffs : null;
    }

    public function render()
    {
        return view('livewire.reinscription.liste-admis');
    }
}
