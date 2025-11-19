<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'element_competence_id',
        'classe_id',
    ];

    public function elementCompetence()
    {
        return $this->belongsTo(ElementCompetence::class);
    }
      public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
