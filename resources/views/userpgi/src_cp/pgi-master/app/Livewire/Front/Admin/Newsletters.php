<?php

namespace App\Livewire\Front\Admin;

use App\Models\Newsletter;
use Livewire\Component;

class Newsletters extends Component
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
        $qry = Newsletter::where("newsletter_object", "like", "%{$this->search}%")
                ->orWhere('newsletter_content', 'like', "%{$this->search}%")
                ->orWhere('newsletter_is_sent', 'like', "%{$this->search}%")
                ->orWhere('newsletter_send_at', 'like', "%{$this->search}%");
        $count = $qry->count();

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $newsletters = $qry->orderBy('id','desc')->offset($this->startLimit)->limit(10)->get();

        return view('livewire.front.admin.newsletters', [
            "newsletters"=>$newsletters,
            "count"=>$count
        ]);
    }
}
