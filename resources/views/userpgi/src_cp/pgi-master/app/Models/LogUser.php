<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class LogUser extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByUser($query, $idUser)
    {
        return $query->where('user_id', $idUser);
    }


    public function scopeByRole($query)
    {
        if(auth()->user()->roles[0]->name == config('constants.roles.superadmin'))
        {
            return $query->whereHas('user.roles', function ($q) {
                $q->whereNotIn('roles.name', [config('constants.roles.superadmin')]);
                });
        }
        elseif(auth()->user()->roles[0]->name == config('constants.roles.admin'))
        {
            return $query->whereHas('user.roles', function ($q) {
                $q->whereNotIn('roles.name', [config('constants.roles.superadmin'), config('constants.roles.admin')]);
                });
        }

    }


    public function scopeByUser($query, $idUser)
    {
        return $query->where('user_id', $idUser);
    }


}
