<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class ManageProfilAccess extends Component
{

    public $roles;
    public $etatWorkflow;
    public array $selection = [];
    public bool $modifying = false;
    public $allRoles;


    public function addProfil(){

        if(!$this->toggleModifying()){
            $existingRoles = $this->roles->pluck('id')->toArray();

            $newRoles = array_diff($this->selection, $existingRoles);
            $removedRoles = array_diff($existingRoles, $this->selection);

            foreach ($newRoles as $profilId) {
                $this->etatWorkflow->roles()->attach($profilId);
            }

            foreach ($removedRoles as $profilId) {
                $this->etatWorkflow->roles()->detach($profilId);
            }
        }

        $this->roles = $this->etatWorkflow->roles;
        $this->allRoles = Role::all();
        $this->selection = $this->roles->pluck('id')->toArray();



        // $this->selection = [];

    }

    /**
     * Active ou désactive le mode de modification.
     *
     * @return bool Retourner la nouvelle valeur de modifying
     */
    public function toggleModifying(){
        $this->modifying = !$this->modifying;
        return $this->modifying;
    }



    public function mount()
    {
        $this->roles = $this->etatWorkflow->roles;
        $this->allRoles = Role::all();
        $this->selection = $this->roles->pluck('id')->toArray();


        // $this->selectedProfils = [1, 3, 5];
    }

    public function render()
    {
        return view('livewire.manage-profil-access');
    }
}
