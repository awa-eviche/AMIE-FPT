<?php

namespace App\Livewire;

use App\Models\TypeNotification;
use Livewire\Component;

class ManageTypeNotification extends Component
{

    public $etatWorkflow;
    public $oldTypeNotification;
    public bool $isModifying = false;
    public $type_notification_id = null;
    // public $allTypeNotification;

    public function mount(){

        $this->oldTypeNotification = $this->etatWorkflow->typeNotification ?? null;
        $this->type_notification_id = $this->oldTypeNotification ? $this->oldTypeNotification->id : null;
    }

    public function setTypeNotification(){
        if(!$this->toggleIsModifying()){
            $this->etatWorkflow->type_notification_id = $this->type_notification_id;
            $this->etatWorkflow->save();

        }

    }

    public function toggleIsModifying(){
        $this->isModifying = !$this->isModifying;

        $this->isModifying;
    }

    public function render()
    {
        return view('livewire.manage-type-notification',
        ["allTypeNotifications" => TypeNotification::all()]
    );
    }
}
