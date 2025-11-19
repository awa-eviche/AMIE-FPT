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

    public function getPaginateByUser($n, $email = null)
{
    if ($email) {
        // Si un email est fourni, on filtre les logs par cet email
        return $this->model->whereHas('user', function ($query) use ($email) {
            $query->where('email', $email);  // Filtrer par email de l'utilisateur
        })->latest()->paginate($n);
    }

    // Sinon, on filtre les logs par user_id (comportement par défaut)
    return $this->model->filterbyUser($userid)->latest()->paginate($n);
}

public function getPaginateByUserEmails($n, $emails = [])
{
    if (!empty($emails)) {
        // Filtrer les logs par emails des utilisateurs
        return $this->model->whereHas('user', function ($query) use ($emails) {
            $query->whereIn('email', $emails);  // Filtrer par liste d'emails
        })->latest()->paginate($n);
    }

    // Si aucune liste d'emails n'est fournie, on retourne tous les logs par défaut
    return $this->model->latest()->paginate($n);
}

    public function store(Array $inputs)
    {
        $inputs['user_id'] = Auth::user()->id;
        return $this->model->create($inputs);
    }

}
