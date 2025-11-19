<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeIndicateur extends Model
{
    use HasFactory;
    protected $fillable =[
        'code',
        'libelle',
        'description',
        'unite',
    ];
    /**
     * Get the indicateur that owns the TypeIndicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function indicateurs()
    {
        return $this->hasMany(Indicateur::class);
    }
}
