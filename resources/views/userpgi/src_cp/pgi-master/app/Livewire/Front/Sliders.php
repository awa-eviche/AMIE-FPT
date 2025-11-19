<?php

namespace App\Livewire\Front;

use App\Models\Entreprise;
use App\Models\FrontSlider;
use Livewire\Component;

class Sliders extends Component
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
        $qry = FrontSlider::where("slider_titre", "like", "%{$this->search}%")
                ->orWhere('created_at', 'like', "%{$this->search}%");
                // ->orderBy($this->orderField, $this->orderDirection);
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $sliders = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.front.sliders', [
            "sliders"=>$sliders,
            "count"=>$count
        ]);
    }
}
