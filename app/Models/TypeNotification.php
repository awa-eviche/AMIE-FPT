<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeNotification extends Model
{
    use HasFactory;

    public function etatWorkflows()
    {
        return $this->hasMany(EtatWorkflow::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_type_notifications');
    }

    protected $fillable = [
        "message",
        "action",
    ];
}
