<?php

namespace App\Livewire\Apprenants\Competence;

use Livewire\Component;
use App\Models\Inscription;
use App\Models\Competence;
use App\Models\DevoirAPC;
use App\Models\Evalute;

class Evaluation extends Component
{
    public $inscription_id;
    public $inscription;
    public $semestre;



    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;

        $this->inscription = Inscription::with('apprenant', 'classe')
            ->findOrFail($inscription_id);

        $niveauId = $this->inscription->classe->niveau_etude_id;
        $anneeId = $this->inscription->annee_academique_id;

        // Ressources de l'année de l'inscription
        $ressourcesDeLAnnee = fn ($q) => $q->when(
            \App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId,
            fn ($qq) => $qq->where('annee_academique_id', $anneeId)
        );

        $this->competencesGenerales = Competence::with(['ressources' => $ressourcesDeLAnnee])
            ->where('type', 'generale')
            ->where('niveau_etude_id', $niveauId)
            ->get();

        $this->competencesParticulieres = Competence::with(['ressources' => $ressourcesDeLAnnee])
            ->where('type', 'particuliere')
            ->where('niveau_etude_id', $niveauId)
            ->get();

        
        $ressourceIds = $this->competencesGenerales->pluck('ressources')->flatten()
            ->merge($this->competencesParticulieres->pluck('ressources')->flatten())
            ->pluck('id')
            ->unique();

        $devoirs = DevoirAPC::whereIn('ressource_id', $ressourceIds)->get();

        foreach ($devoirs as $devoir) {
            $this->mccs[$devoir->ressource_id] = (float) ($devoir->mcc ?? 0);
        }


        $evals = Evalute::where('inscription_id', $this->inscription_id)->get();

        foreach ($evals as $eval) {
            $mcc = (float) ($this->mccs[$eval->ressource_id] ?? 0);
            $composition = (float) ($eval->composition ?? 0);

            $moyenne = round(($mcc + $composition) / 2, 2);

            $this->compositions[$eval->ressource_id] = $composition;
            $this->moyennes[$eval->ressource_id] = $moyenne;
            $this->acquis[$eval->ressource_id] = (bool) $eval->acquis;
        }
    }
public function deleteComposition($ressourceId)
{
    Evalute::where('inscription_id', $this->inscription_id)
        ->where('ressource_id', $ressourceId)
        ->where('semestre', $this->semestre)
        ->update(['composition' => null]);

    $this->compositions[$ressourceId] = null;

    session()->flash('message', 'Note de composition supprimée.');
}





    public function render()
    {
        return view('livewire.apprenant.competence.evaluation');
    }
}
