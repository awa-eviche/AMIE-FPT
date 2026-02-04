<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'competence_id',
        'classe_id',
        'formateur_id'
    ];

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }
      public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function devoirsAPC()
{
    return $this->hasMany(\App\Models\DevoirAPC::class, 'ressource_id');
}
 
}
