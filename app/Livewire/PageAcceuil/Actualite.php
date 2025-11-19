<?php

namespace App\Livewire\PageAcceuil;

use Livewire\Component;

class Actualite extends Component
{
    public $search = "";
    public $startLimit;
    public $count;

    // public $orderField = "";
    // public $orderDirection = "ASC";

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

        $qry = \App\Models\Actualite::where("title", "like", "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%");
        $count = $qry->count();
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
        $actualites = $qry->orderBy('id', 'desc')->offset($this->startLimit)->limit(5)->get();
        return view('livewire.page-acceuil.actualite', [
            "actualites" => $actualites,
            "count" => $count
        ]);

    }
}
