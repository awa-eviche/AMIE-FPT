<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sommation extends Model
{
    use HasFactory;

    protected $table = 'sommations'; 

    protected $fillable = [
        'inscription_id',
        'critere_id',
        'ressource_id',
        'semestre',
        'acquis',
        'nonacquis',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'note' => 'float',
    ];
     public function critere()
    {
        return $this->belongsTo(Critere::class);
    }
   public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id');
    }
}
