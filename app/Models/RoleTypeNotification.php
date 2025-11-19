<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTypeNotification extends Model
{
    use HasFactory;

    public function typeNotifications()
    {
        return $this->belongsToMany(TypeNotification::class);
    }
}
