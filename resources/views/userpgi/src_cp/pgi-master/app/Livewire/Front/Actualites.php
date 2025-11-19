<?php

namespace App\Livewire\Front;

use App\Models\FrontActualite;

use Livewire\Component;

class Actualites extends Component
{

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
        $this->startLimit += 10;
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

        $qry = FrontActualite::where("actualite_titre", "like", "%{$this->search}%")
            ->orWhere('created_at', 'like', "%{$this->search}%");

        $count = $qry->count();

        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;

        $sliders = $qry->orderBy('id', 'desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.front.actualites', [
            "actualites" => $sliders,
            "count" => $count
        ]);
    }
}
