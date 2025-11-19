<?php

namespace App\Repositories;

use App\Models\Agent;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentRepository extends ResourceRepository
{
    

    public function __construct(Agent $agent)
    {
        $this->model = $agent;
    }

    public function getData()
    {
        return $this->model->exceptSuperadmin()->get();
    }

    public function getPaginate($n)
    {
        return $this->model->exceptSuperadmin()->orderBy('nom')->orderBy('prenom')->paginate($n);
    }

    public function getById($id)
    {
        return $this->model->exceptSuperadmin()->findOrFail($id);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getSearchPaginate($query, $n)
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
            ->orderBy('nom')->orderBy('prenom')
            ->paginate($n);
    }

}