<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $table = "role";

    // public function profils()
    // {
    //     return $this->belongsToMany(Profil::class);
    // }

    public function typeNotifications()
    {
        return $this->belongsToMany(TypeNotification::class, 'profil_type_notifications');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function etatWorkflows()
    {
        return $this->belongsToMany(EtatWorkflow::class, 'permission_etat_profils');
    }

    protected $fillable = [
        "nom",
        "code",
        "description",
        "est_actif",
    ];
}
