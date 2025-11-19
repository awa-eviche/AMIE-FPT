<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Etablissement;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Ia;
use App\Models\Ief;
use Livewire\Component;

class CreateUser extends Component
{
    public $user;
    public $is_edit;
    public $roles;
    public $entities;
    public $entity;
    public $oldEntity;
    public $role;
    public $inputClass;
    public $typeRole;
    public $ias;
    public $iefs;
    public $oldTypeRole;

    public function mount(RoleRepository $roleRepository)
    {

        $this->roles = $roleRepository->getList(Auth::user());
        $this->inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600";
        $this->ias = Ia::all();
		$this->iefs = Ief::all();
      /*  $this->entities = [];
        $this->oldEntity = $this->entity = $this->is_edit ? $this->user->userable_id : "";
        $this->oldTypeRole = $this->typeRole = $this->is_edit ? explode('\\',$this->user->userable_type)[sizeof( explode('\\',$this->user->userable_type))-1] : "";
        $this->role = $this->is_edit ? $this->user->role_id : "";
        $this->roles = $roleRepository->getList(Auth::user());

        if($this->typeRole)
        {
            switch($this->typeRole)
            {
                case 'Entreprise':
                    $this->entities = Entreprise::pluck('nom_entreprise','id as value');
                    break;
                case 'Etablissement':
                    $this->entities = Etablissement::pluck('nom','id as value');
                    break;
            }
        } */

    }

    function updatedRole()
    {
      /*  $entreprises = ['chef_entreprise','agent_entreprise','comptable_entreprise'];
        $etablissements = ['chef_cr','surveillant','formateur','agent_cr','chef_de_travaux','surveillant'];
        $apprenants = ['apprenant'];
        $pf2e = ['agent','chef_de_service','coordonnateur','responsable_technique','comptable'];

        $role = Role::find($this->role);
        if($role)
        {
            if(array_search($role->code, $entreprises) !== false){
                $this->typeRole = "Entreprise";
                $this->entities = Entreprise::pluck('nom_entreprise','id as value');
            }
            elseif(array_search($role->code, $apprenants) !== false)
            {
                $this->typeRole= "Apprenant";
            }
            elseif(array_search($role->code, $etablissements) !== false)
            {
                $this->typeRole= "Etablissement";
                $this->entities = Etablissement::pluck('nom','id as value');
            }
            elseif(array_search($role->code, $pf2e) !== false)
            {
                $this->typeRole= "PersonnelPf2e";
            }
        }*/
    }

    public function render()
    {
        return view('livewire.admin.create-user',[
        "roles" => $this->roles, 
        "inputClass" => $this->inputClass,   
        "typeRole" => $this->typeRole,
        "ias" => $this->ias,
        "iefs" => $this->iefs
    ]);
    }
}
