<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evalute extends Model
{
    use HasFactory;
    protected $fillable = [
        "inscription_id",
        "critere_id",
        "ressource_id",    
        "devoirapc_id",    //la ou on stocke le mcc
        "semestre",
      
      "composition",
    ];
    public function critere()
    {
        return $this->belongsTo(Critere::class);
    }
   public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id');
    }
  public function devoir()
    {
        return $this->belongsTo(DevoirAPC::class, 'devoirapc_id');
    }

    /* 🔵 MCC direct */
    public function getMccAttribute()
    {
        return $this->devoir?->mcc ?? 0;
    }

    /* 🔵 Moyenne calculée */
    public function getMoyenneAttribute()
    {
        if ($this->composition === null) return null;
        return ($this->mcc + $this->composition) / 2;
    }
}

