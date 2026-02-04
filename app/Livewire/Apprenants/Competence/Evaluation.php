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

        $this->competencesGenerales = Competence::with('ressources')
            ->where('type', 'generale')
            ->where('niveau_etude_id', $niveauId)
            ->get();

        $this->competencesParticulieres = Competence::with('ressources')
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






    public function render()
    {
        return view('livewire.apprenant.competence.evaluation');
    }
}
