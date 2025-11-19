<?php

namespace App\Livewire\Etablissements;

use App\Models\PersonnelEtablissement;
use App\Models\User;
use Livewire\Component;

class GetAllPersonnel extends Component
{
    public $searchfunction;
    public $search ="";
    public function filterFunction($function){
        $this->searchfunction = $function;
        //dd($this->searchfunction);
    }
    public function setSearch(){
        
    }
    public function resetAll(){
        $this->searchfunction = "";
    }
    public function render()
    {
        
        if (auth()->user()->personnel != null) {
            $etablissementId = auth()->user()->personnel->etablissement_id;
            if ($this->searchfunction) {
                $users = User::query()
                    ->whereHas('personnel', function ($q) use ($etablissementId) {
                        $q->where([
                            ['etablissement_id', $etablissementId],
                            ['fonction', $this->searchfunction] 
                        ]);
                        
                    })
                    
                    ->paginate(10);
            }else{
                $users = User::query()
                        ->whereHas('personnel', function ($q) use ($etablissementId) {
                            $q->where('etablissement_id', $etablissementId);

                        })->orWhere('nom','like',"%{ $this->search }%")
                        ->paginate(10);
            }
           
            $fonctions = PersonnelEtablissement::query()->where('etablissement_id',$etablissementId)
                                                ->get()
                                                ->unique(function($item){
                                                    return $item->fonction;
                                                });
        }
        return view('livewire.etablissements.get-all-personnel', compact('users','fonctions'));
    }
}
