<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function scopeIsDeletable($query)
    {
        return $query->where('is_deletable', true);
    }

    public function isDeletable()
    {
        return $this->is_deletable;
    }
}