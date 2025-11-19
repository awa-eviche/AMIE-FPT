<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


class RoleRepository extends ResourceRepository
{

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    private function save(Role $role, Array $inputs)
    {
        $role->name = $inputs['name'];
        $role->description = $inputs['description'];

        try {
            $role->save();
            return $role;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function getSafeById($id)
    {
        return $this->model->find($id);
    }

    public function getData()
    {
        return $this->model->exceptSuperadmin()->get();
    }

     public function getList($user = null)
    {
        // Si l'utilisateur est un super administrateur, il peut voir tous les rôles sauf ceux du chef d'établissement et autres rôles spécifiques.
        if ($user && $user->isSuperAdmin()) {
            return $this->model->exceptSuperadmin()->orderBy('description')->pluck('description', 'id');
        }
    
        // Si l'utilisateur est un chef d'établissement, on affiche seulement les rôles qui lui sont attribués (par exemple 'formateur', 'gestionnaire', etc.)
        if ($user && ($user->isChefEtablissement() || $user->hasRole('assistante'))) {
            return $this->model->whereIn('name', ['formateur', 'intendant', 'surveillant','chef_de_travaux','comptable_matiere','directeur_etude','gestionnaire','assistante','directrice_centre_application','censeur']) // Remplace par les rôles appropriés
                               ->orderBy('description')
                               ->pluck('description', 'id');
        }
    
        // Par défaut, pour les autres types d'utilisateurs, on filtre avec des exclusions spécifiques.
        return $this->model->exceptSuperadmin()->exceptIa()->exceptAutorite()->exceptChefservice()->orderBy('description')->pluck('description', 'id');
    }

    public function getByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    public function store(Array $inputs)
    {
        $role = $this->save(new $this->model, $inputs);
        if ($role && isset($inputs['permissions'])) {
            $this->setPermissions($role, $inputs['permissions']);
        }
        return $role;
    }

    public function update($role, Array $inputs)
    {
        $updatedRole = $this->save($role, $inputs);
        if ($updatedRole && isset($inputs['permissions'])) {
            $this->setPermissions($updatedRole, $inputs['permissions']);
        }
        return $updatedRole;
    }

    public function destroy($role)
    {
        if (!$role->isDeletable())
            return false;

        if (!empty($role->users->count()))
            return false;

        try {
            $role->delete();
            return true;
        } catch (QueryException $e) {
            return 'error';
        }
    }

    public function setPermissions($role, $permissions)
    {
        $tabPerms = array();
        foreach ($permissions as $idPerm) {
            if (is_numeric($idPerm))
                $tabPerms[] = Permission::findById($idPerm);
        }
        $role->syncPermissions($tabPerms);
        return true;
    }

    // get role by code
    public function getRolseByCode($code)
    {
        return $this->model->where('code', $code)->firstOrFail();
    }


}
