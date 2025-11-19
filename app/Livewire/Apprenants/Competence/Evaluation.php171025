<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Inscription;
use App\Models\Evalute;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

class Evaluation extends Component
{
    public $inscription_id;
    public $selectedsemestre = ''; 

    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;
    }

    #[Computed]
    public function evaluations()
    {
        if (empty($this->selectedsemestre)) {
            return []; // => pas de notes tant que le semestre n'est pas choisi
        }

        return Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', $this->selectedsemestre)
            ->get()
            ->keyBy('critere_id')
            ->toArray();
    }

    public function render()
    {
        $apprenant = Inscription::with('classe')->find($this->inscription_id);

        if (!$apprenant || !$apprenant->classe) {
            return view('livewire.apprenant.competence.evaluation', [
                'apprenant' => null,
                'competencesGenerales' => collect(),
                'competencesParticulieres' => collect(),
                'rowspansGenerales' => [],
                'rowspansParticulieres' => [],
                'evaluations' => [],
                'inscription_id' => null,
            ]);
        }

        $competencesGenerales = Competence::where('niveau_etude_id', $apprenant->classe->niveau_etude_id)
            ->where('type', 'generale')
            ->with('elementCompetences.criteres')
            ->get();

        $rowspansGenerales = [];
        foreach ($competencesGenerales as $k => $comp) {
            $rowspansGenerales[$k] = $comp->elementCompetences->sum(fn($e) => $e->criteres->count());
        }

        $competencesParticulieres = Competence::where('niveau_etude_id', $apprenant->classe->niveau_etude_id)
            ->where('type', 'particuliere')
            ->with('elementCompetences.criteres')
            ->get();

        $rowspansParticulieres = [];
        foreach ($competencesParticulieres as $k => $comp) {
            $rowspansParticulieres[$k] = $comp->elementCompetences->sum(fn($e) => $e->criteres->count());
        }

        return view('livewire.apprenant.competence.evaluation', [
            'apprenant'                => $apprenant,
            'competencesGenerales'     => $competencesGenerales,
            'competencesParticulieres' => $competencesParticulieres,
            'rowspansGenerales'        => $rowspansGenerales,
            'rowspansParticulieres'    => $rowspansParticulieres,
            // ⬇️ IMPORTANT : on passe la valeur calculée
            'evaluations'              => $this->evaluations,
            'inscription_id'           => $this->inscription_id,
        ]);
    }

    #[On('saveDatas')]
    public function saveDatas($datas, $semestre)
    {
        if (empty($semestre)) {
            session()->flash('error', 'Sélectionnez un semestre avant d’enregistrer.');
            return;
        }

        $rows = json_decode($datas, true) ?? [];
        foreach ($rows as $row) {
            if (empty($row['id'])) continue;
            if ($row['note'] === '' || $row['note'] === null) continue;

            Evalute::updateOrCreate(
                [
                    'inscription_id' => $this->inscription_id,
                    'critere_id'     => $row['id'],
                    'semestre'       => $semestre,
                ],
                [
                    'note'         => $row['note'],
                    'date'         => $row['date'] ?? null,
                    'observations' => $row['observations'] ?? null,
                ]
            );
        }

        session()->flash('message', 'Évaluations enregistrées avec succès.');
        
    }
}
