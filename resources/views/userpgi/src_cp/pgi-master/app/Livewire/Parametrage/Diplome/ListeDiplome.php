<?php

namespace App\Livewire\Parametrage\Diplome;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Diplome;

class ListeDiplome extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
        ]);
    }

    function next()
    {
        $this->startLimit += 10 ;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {

    }

    public function render()
    {
        $qry = Diplome::where("nom", "like", "%{$this->search}%")
                        ->orWhere('code', 'like', "%{$this->search}%")
                        ;
                      
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $diplomes = $qry->orderBy('id','desc')->paginate(10);

        return view('livewire.parametrage.diplome.liste-diplome', [
            "diplomes"=>$diplomes,
            "count"=>$count
        ]);
    }
}
