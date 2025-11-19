<?php

namespace App\Livewire\Indicateur;

use App\Models\AnneeAcademique;
use App\Models\Indicateur;
use App\Models\SuiviIndicateur;
use App\Models\TypeIndicateur;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListeIndicateur extends Component
{
    use WithPagination;
    public $idIndicateur;
    public $search;
    public $selectedClasseAnnee;
    public $nameIndicateur;
    public function getRealisation($id,$name){
        $this->idIndicateur = $id;
        $this->nameIndicateur = $name;
    }
    public function close(){
        $this->idIndicateur=''; 
        $this->nameIndicateur=''; 
    }

    public function setSearch(){}

    public function render()
    {   
        $realisations ='';
        if ($this->idIndicateur) {
            if (auth()->user()->personnel) {
                $realisations = SuiviIndicateur::query()
                         ->where([
                            ['indicateur_id',$this->idIndicateur],
                            ['etablissement_id',auth()->user()->personnel->etablissement_id]
                         ])->paginate(10);
                
                
            }
            if (auth()->user()->hasRole(config('constants.roles.superadmin'))) {
                $realisations  = SuiviIndicateur::query()
                         ->where([
                            ['indicateur_id',$this->idIndicateur],
                         ])->paginate(10);
            }
            
            $typeIndicateurs = TypeIndicateur::query()->get();
            $annees = AnneeAcademique::query()->get();
            $indicateurs = Indicateur::query()
                            
                            ->paginate(10);
            return view('livewire.indicateur.liste-indicateur', 
            compact('indicateurs','typeIndicateurs','annees','realisations'));
        }

        if ($this->selectedClasseAnnee) {
            $indicateurs = Indicateur::query()->where('anneeAcademique_id',$this->selectedClasseAnnee)
                                ->paginate(10);
            $typeIndicateurs = TypeIndicateur::query()->get();
            $annees = AnneeAcademique::query()->get();
            return view('livewire.indicateur.liste-indicateur', 
            compact('indicateurs','typeIndicateurs','annees','realisations'));
        }

        $typeIndicateurs = TypeIndicateur::query()->get();
        $annees = AnneeAcademique::query()->get();
        $indicateurs = Indicateur::query()
                        ->whereHas('typeIndicateur',function($query){
                            $query->where('libelle', 'like', "%{$this->search}%");
                        })
                        ->paginate(10);
        return view('livewire.indicateur.liste-indicateur', 
        compact('indicateurs','typeIndicateurs','annees','realisations'));
    }
}
