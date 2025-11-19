<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;
use App\Models\Efpt;
use App\Models\Programme;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Programms extends Model
{
    use HasFactory;
    protected $table = 'programms';

    protected $fillable = [
        "id",
        "grade_id",
        "nom",
        "efpt_id",
    ];

    public function grade()
	{
        return $this->belongsTo(Grade::class, 'grade_id');
	}
   
    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }

    public function etablissement() 
    {
        return $this->belongsTo(Efpt::class, 'efpt_id');
    }  
   
   


}
