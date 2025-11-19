<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspecteur extends Model
{
    use HasFactory;


    public function ia()
    {
        return $this->belongsTo(Ia::class, 'ia_id');
    }

    public function ief()
    {
        return $this->belongsTo(Ief::class, 'ief_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

  

    public $timestamps = false;
    protected $fillable = [
        'chefInspection',
        'specialite',
        'isDeleted',
        'ia_id',
        'ief_id',
        'is_active',
        'user_id',
    ];
}
