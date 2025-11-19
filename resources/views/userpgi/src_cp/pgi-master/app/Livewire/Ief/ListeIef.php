<?php

namespace App\Livewire\Ief;


use App\Models\Ief;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ListeIef extends Component
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

    public function setSearch(){

    }

    public function render()
    {
        $qry = Ief::where('isDeleted', false)
                            ->where(function($query) {
                                $query->where("nom", "like", "%{$this->search}%")
                                    ->orWhere('email', 'like', "%{$this->search}%")
                                    ->orWhere('telephone', 'like', "%{$this->search}%")
                                    ->orWhere('adresse', 'like', "%{$this->search}%");

                            });
                
        
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $iefs = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();
        
        return view('livewire.ief.liste-ief', [
            "iefs"=>$iefs,
            "count"=>$count
        ]);
    }
}