<?php

namespace App\Repositories;

use App\Models\LogUser;
use Illuminate\Support\Facades\Auth;


class LogUserRepository extends ResourceRepository
{

    public function __construct(LogUser $logUser)
    {
        $this->model = $logUser;
    }

    public function getPaginate($n)
    {
        return $this->model->byRole()->latest()->paginate($n);
    }

    public function getPaginateByUser($n, $userid = null)
    {
        return $this->model->filterbyUser($userid)->latest()->paginate($n);
    }

    public function store(Array $inputs)
    {
        $inputs['user_id'] = Auth::user()->id;
        return $this->model->create($inputs);
    }

}
