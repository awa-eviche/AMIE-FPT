<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;

abstract class ResourceRepository
{

    protected $model;

    public function getPaginate($n)
    {
        return $this->model->paginate($n);
    }

    public function store(Array $inputs)
    {
        return $this->model->create($inputs);
    }

    public function getData()
    {
        return $this->model->get();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getSafeById($id)
    {
        return $this->model->find($id);
    }

    public function update($id, Array $inputs)
    {
        $model = $this->getById($id);
        $model->update($inputs);
        return $model;
    }

    public function destroy($id)
    {
        try {
            $this->getById($id)->delete();
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function safeDestroy($id)
    {
        $model = $this->getById($id);
        $model->is_deleted = true;
        return $model->save();
    }

    public function getNb()
    {
        return $this->model->count();
    }

}
