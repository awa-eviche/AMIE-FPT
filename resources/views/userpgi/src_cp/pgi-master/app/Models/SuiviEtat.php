<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviEtat extends Model
{
    use HasFactory;

    public function etatWorkflow()
    {
        return $this->belongsTo(EtatWorkflow::class, 'etat_workflow_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suiviEtatable()
    {
        return $this->morphTo();
    }
}
