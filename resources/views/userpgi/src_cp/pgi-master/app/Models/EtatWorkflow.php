<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatWorkflow extends Model
{
    use HasFactory;

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function etatSuivant()
    {
        return $this->belongsTo(EtatWorkflow::class, 'etat_suivant_id');
    }

    public function etatRejet()
    {
        return $this->belongsTo(EtatWorkflow::class, 'etat_rejet_id');
    }

    public function typeNotification()
    {
        return $this->belongsTo(TypeNotification::class);
    }

    public function suiviEtats()
    {
        return $this->hasMany(SuiviEtat::class, 'etat_workflow_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_etat_roles');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'etat_id');
    }

    protected $fillable = [
        'workflow_id',
        'type_notification_id',
        'etat_suivant_id',
        'etat_rejet_id',
        'position',
        'code',
        'libelle',
        'description',
        'bouton_suivant',
        'bouton_rejet',
        'est_rejetable',
        'libelle_rejet',
        'est_fin',
        "status",
    ];

}
