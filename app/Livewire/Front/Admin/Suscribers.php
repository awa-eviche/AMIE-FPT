<?php

namespace App\Livewire\Front\Admin;

use App\Models\NewslettersSuscriber;
use Livewire\Component;

class Suscribers extends Component
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
        $qry = NewslettersSuscriber::where("suscriber_email", "like", "%{$this->search}%")
                ->orWhere('created_at', 'like', "%{$this->search}%");
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $suscribers = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.front.admin.suscribers', [
            "suscribers"=>$suscribers,
            "count"=>$count
        ]);
    }
}
