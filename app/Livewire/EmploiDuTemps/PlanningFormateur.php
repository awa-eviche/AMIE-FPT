<?php

namespace App\Livewire\EmploiDuTemps;

use App\Models\AnneeAcademique;
use App\Models\CreneauEmploiDuTemps;
use App\Models\PersonnelEtablissement;
use Livewire\Component;

class PlanningFormateur extends Component
{
    public $anneeAcademiqueId;
    public $typePlanning = 'hebdomadaire'; // 'hebdomadaire' | 'semestriel'
    public $semaine;
    public $semaineMin = 1;
    public $semaineMax = 52;
    public $semestre = 1;

    public function mount(): void
    {
        abort_unless(auth()->user()->hasRole('formateur'), 403);

        $this->anneeAcademiqueId = session('annee_academique_id')
            ?? \App\Services\AnneeDesNotes::anneeParDefaut()
            ?? AnneeAcademique::where('is_open', true)->value('id')
            ?? AnneeAcademique::orderByDesc('id')->value('id');
        $this->semaine = now()->isoWeek();
    }

    public function getFormateurProperty(): ?PersonnelEtablissement
    {
        return auth()->user()->personnel ?? null;
    }

    /**
     * Retourne les créneaux groupés par classe, puis par jour.
     * Structure : Collection<classeId, ['classe' => Classe, 'parJour' => Collection<jour, Collection<Creneau>>]>
     */
    public function getCreneauxProperty()
    {
        if (!$this->formateur || !$this->anneeAcademiqueId) return collect();

        $creneaux = CreneauEmploiDuTemps::where('personnel_etablissement_id', $this->formateur->id)
            ->whereHas('emploiDuTemps', function ($q) {
                $q->where('annee_academique_id', $this->anneeAcademiqueId)
                  ->where('type_planning', $this->typePlanning);
                if ($this->typePlanning === 'hebdomadaire') {
                    $q->where('semaine', $this->semaine)->whereNull('semestre');
                } else {
                    $q->where('semestre', $this->semestre)->whereNull('semaine');
                }
            })
            ->with(['emploiDuTemps.classe', 'matiere', 'elementCompetence'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        return $creneaux
            ->groupBy(fn($cr) => $cr->emploiDuTemps?->classe_id)
            ->map(fn($classeCreneaux) => [
                'classe'  => $classeCreneaux->first()->emploiDuTemps?->classe,
                'parJour' => $classeCreneaux->groupBy('jour'),
            ]);
    }

    public function updatedAnneeAcademiqueId(): void
    {
        session()->put('annee_academique_id', $this->anneeAcademiqueId);
    }

    public function updatedSemestre(): void
    {
        $this->semestre = max(1, min(2, (int) $this->semestre));
    }

    public function semainePrecedente(): void
    {
        if ($this->semaine > $this->semaineMin) $this->semaine--;
    }

    public function semaineSuivante(): void
    {
        if ($this->semaine < $this->semaineMax) $this->semaine++;
    }

    public function updatedSemaineMin(): void
    {
        $this->semaineMin = max(1, (int) $this->semaineMin);
        if ($this->semaine < $this->semaineMin) $this->semaine = $this->semaineMin;
    }

    public function updatedSemaineMax(): void
    {
        $this->semaineMax = min(53, (int) $this->semaineMax);
        if ($this->semaine > $this->semaineMax) $this->semaine = $this->semaineMax;
    }

    public function render()
    {
        return view('livewire.emploi-du-temps.planning-formateur', [
            'annees'   => AnneeAcademique::orderByDesc('id')->get(),
            'creneaux' => $this->creneaux,
        ]);
    }
}
