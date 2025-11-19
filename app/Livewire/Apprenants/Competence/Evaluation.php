<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Inscription;
use App\Models\Evalute;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class Evaluation extends Component
{
    public $inscription_id;
    public $selectedsemestre = '';

    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;
    }

    public function updatedSelectedsemestre($value)
    {
        $this->loadEvaluations($value);
    }

    public function loadEvaluations($semestre)
    {
        if (empty($semestre)) {
            $this->evaluations = [];
            return;
        }

        $this->evaluations = Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', $semestre)
            ->get()
            ->keyBy(function ($item) {
                return $item->ressource_id ?? $item->critere_id;
            })
            ->toArray();
    }

    #[Computed]
    public function evaluations()
    {
        if (empty($this->selectedsemestre)) {
            return [];
        }

        return Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', $this->selectedsemestre)
            ->get()
            ->keyBy(function ($item) {
                return $item->ressource_id ?? $item->critere_id;
            })
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

        $user = auth()->user();
        $classe = $apprenant->classe;

        // 🔹 Si formateur → filtrer ses compétences
        if ($user->hasRole('formateur')) {
            $competenceIds = DB::table('classe_formateur_competence')
                ->where('classe_id', $classe->id)
                ->where('formateur_id', $user->id)
                ->pluck('competence_id')
                ->toArray();

            if (empty($competenceIds)) {
                $competencesGenerales = collect();
                $competencesParticulieres = collect();
            } else {
                $competencesGenerales = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
                    ->where('type', 'generale')
                    ->whereIn('id', $competenceIds)
                    ->with('elementCompetences.ressource')
                    ->get();

                $competencesParticulieres = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
                    ->where('type', 'particuliere')
                    ->whereIn('id', $competenceIds)
                    ->with('elementCompetences.criteres')
                    ->get();
            }
        } else {
            // 🔸 Autres rôles (chef, directeur, admin)
            $competencesGenerales = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
                ->where('type', 'generale')
                ->with('elementCompetences.ressource')
                ->get();

            $competencesParticulieres = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
                ->where('type', 'particuliere')
                ->with('elementCompetences.criteres')
                ->get();
        }

        // 🔹 Rowspans dynamiques
        $rowspansGenerales = [];
        foreach ($competencesGenerales as $k => $comp) {
            $rowspansGenerales[$k] = $comp->elementCompetences->sum(fn($e) => $e->ressource()->count());
        }

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

            $isRessource = isset($row['type']) && $row['type'] === 'ressource';

            $attributes = [
                'inscription_id' => $this->inscription_id,
                'semestre'       => $semestre,
            ];

            if ($isRessource) {
                $attributes['ressource_id'] = $row['id'];
            } else {
                $attributes['critere_id'] = $row['id'];
            }

            Evalute::updateOrCreate(
                $attributes,
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
