<?php

namespace App\Livewire\DFPT;

use App\Models\AnneeAcademique;
use App\Models\Indicateur;
use App\Models\SuiviIndicateur;
use App\Models\TypeIndicateur;
use Livewire\Component;

class Getallindiacteurs extends Component
{
    public $search;
    public $selectedClasseAnnee;
    public $annees;
    public $idIndicateur;
    public $nameIndicateur;
    
    public function getRealisations($id, $name){
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
                         ])
                         ->whereHas('indicateur',function($query){
                            $query->where('public',1);
                         })->with('indicateur')
                         ->paginate(10);
                
                
            }
            if (auth()->user()->hasRole(config('constants.roles.superadmin'))||auth()->user()->hasRole(config('constants.roles.ia'))) {
                $realisations  = SuiviIndicateur::query()
                         ->where([
                            ['indicateur_id',$this->idIndicateur],
                         ])->paginate(10);
                         
            }
            
            $typeIndicateurs = TypeIndicateur::query()->get();
            $annees = AnneeAcademique::query()->get();
            $indicateurs = Indicateur::query()
                            
                            ->paginate(10);
            return view('livewire.dfpt.getallindiacteurs', 
            compact('indicateurs','typeIndicateurs','annees','realisations'));
        }
        if ($this->selectedClasseAnnee) {
            $indicateurs = Indicateur::query()->where([
                ['anneeAcademique_id',$this->selectedClasseAnnee],
                ['public',1]
            ])
                                ->paginate(10);
            $typeIndicateurs = TypeIndicateur::query()->get();
            $annees = AnneeAcademique::query()->get();
            return view('livewire.dfpt.getallindiacteurs', 
            compact('indicateurs','typeIndicateurs','annees','realisations'));
        }
        $this->annees = AnneeAcademique::query()->get();
        $indicateurs = Indicateur::query()->where('public',1)
                        ->whereHas('typeIndicateur',function($query){
                            $query->where('libelle', 'like', "%{$this->search}%");
                        })
                        ->paginate(5);
        // $realisations = SuiviIndicateur::query()
        // ->whereHas('indicateur',function($query){
        //     $query->where('public',1)
        //     ->orwhere('anneeAcademique_id',$this->selectedClasseAnnee);
           
        // })->paginate(10);
        
        return view('livewire.dfpt.getallindiacteurs',compact('realisations','indicateurs'));
    }
}
