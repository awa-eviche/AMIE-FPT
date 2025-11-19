<?php

namespace App\Livewire;

use Livewire\Component;

class OneNotification extends Component
{
    public $data_decoded;
    public $notification;
    public bool $consultable = false;
    public $objects;

    public function mount(){
        $this->consultable = $this->data_decoded['objects'] != null
        && $this->data_decoded['objects'] != "null"
        && json_decode($this->data_decoded['objects'])->entity !== null
        && json_decode($this->data_decoded['objects'])->route !== null
        ;

        if($this->consultable){
            $this->objects = json_decode($this->data_decoded['objects']);
        }else
            $this->objects = null;


    }

    public function marquerCommeLue(){ 
        $this->notification->read_at = now();
        $this->notification->save();
    }
    public function render()
    {
        return view('livewire.one-notification');
    }
}
