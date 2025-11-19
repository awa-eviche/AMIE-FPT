<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
    }

    public function scopeIsDeletable($query)
    {
        return $query->where('is_deletable', true);
    }

    public function scopeExceptSuperadmin($query)
    {
        return $query->where('name', '!=', config('constants.roles.superadmin'));
    }

    public function scopeExceptIa($query)
    {
        return $query->where('name', '!=', config('constants.roles.ia'));
    }

    public function scopeExceptChefetablissement($query)
    {
        return $query->where('name', '!=', config('constants.roles.chef_etablissement'));
    }


    public function scopeExceptSurveillant($query)
    {
        return $query->where('name', '!=', config('constants.roles.surveillant'));
    }


    public function scopeExceptFormateur($query)
    {
        return $query->where('name', '!=', config('constants.roles.formateur'));
    }


    public function scopeExceptIntendant($query)
    {
        return $query->where('name', '!=', config('constants.roles.intendant'));
    }



    public function scopeExceptCheftravaux($query)
    {
        return $query->where('name', '!=', config('constants.roles.chef_de_travaux'));
    }


    public function scopeExceptAutorite($query)
    {
        return $query->where('name', '!=', config('constants.roles.autorite'));
    }

    public function scopeExceptChefservice($query)
    {
        return $query->where('name', '!=', config('constants.roles.chef_de_service'));
    }

  

    public function isDeletable()
    {
        return $this->is_deletable;
    }

    public function isAdmin()
    {
        return $this->name === config('constants.roles.admin');
    }


    public function typeNotifications()
    {
        return $this->belongsToMany(TypeNotification::class, 'role_type_notifications');
    }


    public function etatWorkflows()
    {
        return $this->belongsToMany(EtatWorkflow::class, 'permission_etat_roles');
    }


}