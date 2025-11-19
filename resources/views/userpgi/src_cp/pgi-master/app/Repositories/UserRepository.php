<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserRepository extends ResourceRepository
{
    protected $roleRepository;

    public function __construct(User $user, RoleRepository $roleRepository)
    {
        $this->model = $user;
        $this->roleRepository = $roleRepository;
    }

    public function getData()
    {
        return $this->model->exceptSuperadmin()->get();
    }

    public function getPaginate($n, $idEtablissement = null)
    {
        return $this->model->exceptSuperadmin()->byEtablissement($idEtablissement)->orderBy('nom')->orderBy('prenom')->paginate($n);
    }

    public function getById($id)
    {
        return $this->model->exceptSuperadmin()->findOrFail($id);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getByIdAndRole($id, $role)
    {
        return $this->model->filterByRole($role)->findOrFail($id);
    }

    public function getList()
    {
        return $this->model->select(DB::raw("CONCAT(prenom,' ',nom) AS fullname"), 'id')
            ->exceptSuperadmin()->orderBy('fullname')->pluck('fullname', 'id');
    }

    public function getListByRole($role, $idEtablissement = null)
    {
        return $this->model->select(DB::raw("CONCAT(prenom,' ',nom) AS fullname"), 'id')
            ->role($role)->byEtablissement($idEtablissement)->exceptSuperadmin()->orderBy('fullname')->pluck('fullname', 'id');
    }

    public function getDataByRole($role)
    {
        return $this->model->filterByRole($role)->orderBy('nom')->orderBy('prenom')->get();
    }

    public function getSearchPaginate($query, $n, $idEtablissement = null)
    {
        return $this->model
            ->orWhere('nom', 'LIKE', '%' . $query . '%')
            ->orWhere('prenom', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('telephone', 'LIKE', '%' . $query . '%')
            ->orWhereHas('roles', function ($q) use ($query) {
                $q->where('description', 'LIKE', '%' . $query . '%');
            })
            ->exceptSuperadmin()
            ->byEtablissement($idEtablissement)
            ->orderBy('nom')->orderBy('prenom')
            ->paginate($n);
    }


    public function getDataPaginateByRole($role, $n)
    {
        return $this->model->filterByRole($role)->exceptSuperadmin()->orderBy('nom')->orderBy('prenom')->paginate($n);
    }

    public function store(array $inputs)
    {
        $pwd = !empty($inputs['password']) ? $inputs['password'] : config('constants.password');
        $inputs['password'] = $this->getPasswordHash($pwd);

        try {
            $user = $this->model->create($inputs);
           

        } catch (QueryException $e) {
            return null;
            Log::info($e);
        }
        if ($user && isset($inputs['roles'])) {
            $this->setRoles($user, $inputs['roles']);
        }
        return $user;
    }


    public function getEtablissementInfoFromUser($idEtablissement)
    {
        return $this->model->byEtablissement($idEtablissement)->get();
    }

    public function update($id, array $inputs)
    {
        $user = $this->getById($id);
        $userUpdated = $user->update($inputs);
        if ($userUpdated && isset($inputs['roles'])) {
            $this->setRoles($user, $inputs['roles']);
        }
        return $userUpdated;
    }

    public function destroy($user)
    {
        if (Auth::user()->id == $user->id)
            return false;
        try {
            $user->delete();
            return true;
        } catch (QueryException $e) {
            return 'error';
        }
    }

    public function forceDestroy($user)
    {
        if (Auth::user()->id == $user->id)
            return false;
        try {
            $user->forceDelete();
            return true;
        } catch (QueryException $e) {
            return 'error';
        }
    }

    public function setRoles($user, $roles)
    {
        $tabRoles = array();
        foreach ($roles as $idRole) {
            $tabRoles[] = $this->roleRepository->getSafeById($idRole);
        }
        $user->syncRoles($tabRoles);
        return true;
    }

    public function changePwd($user, $inputs)
    {
        if (password_verify($inputs['old_password'], $user->password)) {
            $hashedpassword = $this->getPasswordHash($inputs['new_password']);
            $user->password = $hashedpassword;
            $user->save();
            return true;
        }
        return false;
    }

    public function updateProfile(User $user, array $inputs)
    {
        return $user->update($inputs);
    }

    public function updatePhoto($user, $nomPhoto)
    {
        $user->profile_photo_path = $nomPhoto;
        return $user->save();
    }

    public function setRole($user, $idRole)
    {
        $role = $this->roleRepository->getSafeById($idRole);
        $user->syncRoles($role);
        return true;
    }

    public function resetPassword($user)
    {
        $user->password = $this->getPasswordHash(config('constants.password'));
        return $user->save();
    }

    public function changeStatus($user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return $user;
    }

    public function restrictAccess($user, $action)
    {
        $user->is_active = !$action;
        $user->save();
        return $user;
    }

    public function getNb()
    {
        return $this->model->count();
    }

    private function getPasswordHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function getStats($idEtablissement = null, $except = [])
    {
        $roles = $this->roleRepository->getData();
        $data = array(
            'total' => 0,
            'items' => []
        );
        foreach ($roles as $role) {
            if ($role->name != config('constants.roles.superadmin') && !in_array($role->name, $except)) {
                $nb = $this->model->role([$role->name])->byEtablissement($idEtablissement)->count();
                $data['items'][$role->name] = [
                    'nom' => $role->description,
                    'nb' => $nb
                ];
                $data['total'] += $nb;
            }
        }
        return $data;
    }

    public function getUsersByRoles($roleIds)
    {
        return User::whereHas('roles', function ($query) use ($roleIds) {
            $query->whereIn('role_id', $roleIds);
        })->get();
    }

    public function getUsersByRoleCode($roleCodes)
    {
        return User::whereHas('roles', function ($query) use ($roleCodes) {
            $query->whereIn('code', $roleCodes);
        })->get();
    }
    public function getAllComiteMembers()
    {
        return $this->model
        ->where(function ($query) {
            $query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('roles')
                    ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereRaw('model_has_roles.model_id = users.id')
                    ->where('roles.code', 'membre_du_comite');
            })
            ->orWhere(function ($query) {
                $query->where('userable_type', 'App\\Models\\Agent')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('agents')
                            ->whereRaw('users.userable_id = agents.id')
                            ->where('agents.estMembreComite', 1);
                    });
            });
        })
        ->get();
    }

    // a function to say, if a user a member of comite or not. to be the member comite, it must have the role with the comite_externe or (have userable_type A\Models\Agent and the corresponding agent must have estComiteMembre to true
    public function isMemberComite($user){
        
    }
}
