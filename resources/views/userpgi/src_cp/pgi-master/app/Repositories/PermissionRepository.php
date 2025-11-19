<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Database\QueryException;


class PermissionRepository extends ResourceRepository
{

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    private function save(Permission $permission, Array $inputs)
    {
        $permission->description = $inputs['description'];

        try {
            $permission->save();
            return $permission;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function getList()
    {
        return $this->model->orderBy('description')->pluck('description', 'id');
    }

    public function update($id, Array $inputs)
    {
        return $this->save($this->getById($id), $inputs);
    }

    public function destroy($id)
    {
        $permission = $this->getById($id);

        if (!$permission->isDeletable())
            return false;

        try {
            $permission->delete();
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

}